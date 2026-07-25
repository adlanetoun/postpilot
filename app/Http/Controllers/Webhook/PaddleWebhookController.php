<?php

namespace App\Http\Controllers\Webhook;

use Laravel\Paddle\Http\Controllers\WebhookController as CashierWebhookController;
use App\Models\User;
use App\Services\CreditLedgerService;
use Illuminate\Support\Facades\Log;

class PaddleWebhookController extends CashierWebhookController
{
    /**
     * Handle transaction completed event from Paddle.
     */
    protected function handleTransactionCompleted(array $payload): void
    {
        parent::handleTransactionCompleted($payload);

        Log::info('Paddle transaction completed webhook received', ['id' => $payload['data']['id'] ?? null]);

        $customData = $payload['data']['custom_data'] ?? [];
        $userId = $customData['user_id'] ?? null;
        $credits = (int) ($customData['credits'] ?? 0);

        if ($userId && $credits > 0) {
            $user = User::find($userId);
            if ($user) {
                $transactionId = $payload['data']['id'] ?? null;
                $user->addCampaignCredits(
                    $credits,
                    'purchase',
                    'Paddle Transaction ' . ($transactionId ?? ''),
                    $transactionId,
                    'paddle_transaction'
                );
                Log::info("Granted {$credits} credits to user {$userId} via Paddle transaction.");
            }
        }
    }
}
