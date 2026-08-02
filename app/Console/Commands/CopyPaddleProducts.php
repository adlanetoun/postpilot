<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CopyPaddleProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paddle:copy-products
                            {--sandbox-key= : The Paddle Sandbox API Key}
                            {--live-key= : The Paddle Live API Key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy products and prices from Paddle Sandbox to Paddle Live';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sandboxKey = $this->option('sandbox-key') ?: $this->secret('Enter your Paddle Sandbox API Key (from Account 1)');
        $liveKey = $this->option('live-key') ?: $this->secret('Enter your Paddle Live API Key (from Account 2)');

        if (! $sandboxKey || ! $liveKey) {
            $this->error('Both Sandbox API Key and Live API Key are required.');

            return self::FAILURE;
        }

        $this->info('Fetching products from Paddle Sandbox...');

        $sandbox = config('cashier.sandbox');
        $baseUrl = $sandbox ? 'https://sandbox-api.paddle.com' : 'https://api.paddle.com';

        $response = Http::withToken($sandboxKey)
            ->get("{$baseUrl}/products", [
                'status' => 'active',
                'include' => 'prices',
            ]);

        if ($response->failed()) {
            $this->error('Failed to fetch products from Sandbox API: '.$response->body());

            return self::FAILURE;
        }

        $sandboxProducts = $response->json('data', []);
        if (empty($sandboxProducts)) {
            $this->warn('No products found in Sandbox account.');

            return self::SUCCESS;
        }

        $this->info(sprintf('Found %d products in Sandbox. Starting migration to Live...', count($sandboxProducts)));

        $priceMapping = [];

        foreach ($sandboxProducts as $sandboxProduct) {
            $productName = $sandboxProduct['name'] ?? 'Untitled Product';
            $this->line('');
            $this->info(sprintf('Processing product: %s (%s)', $productName, $sandboxProduct['id']));

            // Create product in Live
            $productPayload = [
                'name' => $productName,
                'tax_category' => $sandboxProduct['tax_category'] ?? 'standard',
            ];

            if (! empty($sandboxProduct['description'])) {
                $productPayload['description'] = $sandboxProduct['description'];
            }

            if (! empty($sandboxProduct['type'])) {
                $productPayload['type'] = $sandboxProduct['type'];
            }

            if (! empty($sandboxProduct['image_url'])) {
                $productPayload['image_url'] = $sandboxProduct['image_url'];
            }

            $liveProductResp = Http::withToken($liveKey)
                ->post('https://api.paddle.com/products', $productPayload);

            if ($liveProductResp->failed()) {
                $this->error(sprintf('  Failed to create product "%s" in Live: %s', $productName, $liveProductResp->body()));

                continue;
            }

            $liveProduct = $liveProductResp->json('data');
            $liveProductId = $liveProduct['id'];
            $this->info(sprintf('  -> Created Live Product ID: %s', $liveProductId));

            // Copy prices associated with this product
            $sandboxPrices = $sandboxProduct['prices'] ?? [];
            foreach ($sandboxPrices as $sandboxPrice) {
                $priceDesc = $sandboxPrice['description'] ?? $productName;

                $pricePayload = [
                    'product_id' => $liveProductId,
                    'description' => $priceDesc,
                    'unit_price' => [
                        'amount' => (string) ($sandboxPrice['unit_price']['amount'] ?? '0'),
                        'currency_code' => $sandboxPrice['unit_price']['currency_code'] ?? 'USD',
                    ],
                ];

                if (! empty($sandboxPrice['billing_cycle'])) {
                    $pricePayload['billing_cycle'] = [
                        'interval' => $sandboxPrice['billing_cycle']['interval'] ?? 'month',
                        'frequency' => (int) ($sandboxPrice['billing_cycle']['frequency'] ?? 1),
                    ];
                }

                if (! empty($sandboxPrice['trial_period'])) {
                    $pricePayload['trial_period'] = [
                        'interval' => $sandboxPrice['trial_period']['interval'] ?? 'day',
                        'frequency' => (int) ($sandboxPrice['trial_period']['frequency'] ?? 14),
                    ];
                }

                if (! empty($sandboxPrice['tax_mode'])) {
                    $pricePayload['tax_mode'] = $sandboxPrice['tax_mode'];
                }

                if (isset($sandboxPrice['quantity'])) {
                    $pricePayload['quantity'] = $sandboxPrice['quantity'];
                }

                $livePriceResp = Http::withToken($liveKey)
                    ->post('https://api.paddle.com/prices', $pricePayload);

                if ($livePriceResp->failed()) {
                    $this->error(sprintf('    Failed to create price "%s" in Live: %s', $sandboxPrice['id'], $livePriceResp->body()));

                    continue;
                }

                $livePrice = $livePriceResp->json('data');
                $livePriceId = $livePrice['id'];

                $this->info(sprintf('    -> Price Copied! Sandbox ID: %s => Live ID: %s', $sandboxPrice['id'], $livePriceId));

                $priceMapping[] = [
                    'product_name' => $productName,
                    'sandbox_price_id' => $sandboxPrice['id'],
                    'live_price_id' => $livePriceId,
                    'amount' => sprintf('%s %s', ($sandboxPrice['unit_price']['amount'] ?? 0) / 100, $sandboxPrice['unit_price']['currency_code'] ?? 'USD'),
                ];
            }
        }

        $this->line('');
        $this->info('=====================================================');
        $this->info('  PADDLE MIGRATION COMPLETED SUCCESSFULLY!');
        $this->info('=====================================================');
        $this->table(
            ['Product', 'Sandbox Price ID', 'New Live Price ID', 'Amount'],
            $priceMapping
        );

        return self::SUCCESS;
    }
}
