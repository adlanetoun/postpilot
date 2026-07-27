<?php

namespace App\Http\Controllers\Webhook;

use Laravel\Paddle\Http\Controllers\WebhookController as CashierWebhookController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaddleWebhookController extends CashierWebhookController
{
    /**
     * Handle a Paddle webhook call.
     */
    public function __invoke(Request $request)
    {
        Log::info('Paddle webhook payload received', [
            'event_type' => $request->input('event_type'),
            'id' => $request->input('data.id'),
        ]);

        return parent::__invoke($request);
    }

    /**
     * Handle transaction completed event from Paddle.
     */
    protected function handleTransactionCompleted(array $payload)
    {
        $transactionId = $payload['data']['id'] ?? null;
        $customData = $payload['data']['custom_data'] ?? [];
        $userId = $customData['user_id'] ?? null;
        $credits = (int) ($customData['credits'] ?? 0);

        Log::info('Paddle transaction.completed event processing', [
            'id' => $transactionId,
            'user_id' => $userId,
            'credits' => $credits,
        ]);

        // Fallback 1: Resolve user by customer email if user_id is missing or not found
        $user = null;
        if ($userId) {
            $user = User::find($userId);
        }

        if (! $user) {
            $customerEmail = $payload['data']['customer']['email']
                ?? $payload['data']['customer_email']
                ?? null;

            if ($customerEmail) {
                $user = User::where('email', $customerEmail)->first();
            }
        }

        // Fallback 2: Resolve credits by price ID matching if credits count is missing
        if ($credits <= 0) {
            $items = $payload['data']['items'] ?? [];
            foreach ($items as $item) {
                $priceId = $item['price']['id'] ?? $item['price_id'] ?? null;
                if ($priceId) {
                    if ($priceId === config('services.paddle.price_1_campaign')) {
                        $credits += 1;
                    } elseif ($priceId === config('services.paddle.price_3_campaigns')) {
                        $credits += 3;
                    } elseif ($priceId === config('services.paddle.price_10_campaigns')) {
                        $credits += 10;
                    }
                }
            }
        }

        if ($user && $credits > 0) {
            $user->addCampaignCredits(
                $credits,
                'purchase',
                'Paddle Transaction ' . ($transactionId ?? ''),
                $transactionId,
                'paddle_transaction'
            );
            Log::info("Granted {$credits} credits to user {$user->id} ({$user->email}) via Paddle transaction {$transactionId}.");
        } else {
            Log::warning("Could not grant Paddle credits — User or Credits unresolved.", [
                'user_found' => (bool) $user,
                'credits' => $credits,
                'transaction_id' => $transactionId,
            ]);
        }

        return parent::handleTransactionCompleted($payload);
    }
}
