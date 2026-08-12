<?php

namespace App\Jobs;

use App\Models\CreditTransaction;
use App\Models\ProcessedWebhook;
use App\Models\User;
use App\Models\WebhookLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessDodoWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     * After 5 failures, the job is permanently failed.
     */
    public $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public $maxExceptions = 3;

    /**
     * Calculate the number of seconds to wait before retrying.
     * Exponential backoff: 10s, 30s, 60s, 120s, 300s
     */
    public function backoff(): array
    {
        return [10, 30, 60, 120, 300];
    }

    public function __construct(public WebhookLog $webhookLog) {}

    public function handle(): void
    {
        $payload = $this->webhookLog->payload;
        $eventType = $this->webhookLog->event_type;

        // FIX E: Webhook secret boot check — log CRITICAL if not configured
        $webhookSecret = config('services.dodo.webhook_secret');
        if (empty($webhookSecret)) {
            Log::critical('DODO_WEBHOOK_SECRET is not configured. Webhook processing is INSECURE — any caller can trigger credit grants and refunds.', [
                'webhook_log_id' => $this->webhookLog->id,
                'event_type' => $eventType,
            ]);
        }

        // FIX A: Defense-in-depth signature verification in the queued job
        // The HTTP controller verifies the signature synchronously, but we re-verify
        // here to protect against tampering between write and read of the webhook log.
        $storedSignature = $this->webhookLog->getAttribute('signature');
        if (! empty($storedSignature)) {
            $recomputed = hash_hmac('sha256', json_encode($payload), (string) $webhookSecret);
            if (! hash_equals($recomputed, (string) $storedSignature)) {
                Log::critical('Dodo webhook signature mismatch in queued job — possible tampering or replay.', [
                    'webhook_log_id' => $this->webhookLog->id,
                    'event_type' => $eventType,
                ]);
                $this->webhookLog->update([
                    'processed_at' => now(),
                    'payload' => array_merge($payload, ['signature_invalid' => true]),
                ]);

                return;
            }
        } elseif (! empty($webhookSecret)) {
            // Signature column missing — the controller has not been updated to store the
            // signature alongside the payload. Log at INFO so we know defense-in-depth
            // is currently inactive, but do not block (HTTP-layer check already passed).
            Log::info('Dodo webhook signature not stored on WebhookLog — defense-in-depth signature check skipped.', [
                'webhook_log_id' => $this->webhookLog->id,
            ]);
        }

        // STRICT ALLOW-LIST: Only process known financial event types
        $allowedEvents = [
            'payment.succeeded',
            'payment.refunded',
            'payment.failed',
        ];

        if (! in_array($eventType, $allowedEvents, true)) {
            $this->webhookLog->update(['processed_at' => now(), 'payload' => array_merge($payload, ['ignored' => true])]);

            return; // Silently ignore non-financial events
        }

        try {
            // Use IMMEDIATE transaction for safe processing without SQLite lock upgrades
            DB::transaction(function () use ($payload, $eventType) {
                // Idempotency Check using the event ID from payload (Dodo uses 'event_id' or 'id')
                // FIX LEAK-7: Tie-break to WebhookLog id so retries of the SAME
                // logical event always resolve to the same event_id even if
                // Dodo mutates the payload (e.g. adds a `retry_count` field)
                // between attempts. Previously md5(json_encode($payload)) would
                // shift across attempts, causing the same event to be credited
                // multiple times for one payment.
                $eventId = $payload['event_id']
                    ?? $payload['id']
                    ?? ('webhook_log_'.$this->webhookLog->id);

                // If it already exists, we skip processing
                if (ProcessedWebhook::where('event_id', $eventId)->exists()) {
                    $this->webhookLog->update(['processed_at' => now(), 'payload' => array_merge($payload, ['ignored_duplicate' => true])]);

                    return;
                }

                // Record idempotency log
                ProcessedWebhook::create([
                    'event_id' => $eventId,
                    'event_type' => $eventType,
                    'payload' => $payload,
                    'created_at' => now(),
                ]);

                $customerEmail = $payload['data']['customer']['email'] ?? null;
                $amount = $payload['data']['total_amount'] ?? 0;

                if (! $customerEmail) {
                    Log::warning("Received {$eventType} webhook with no customer email; skipping credit/refund logic.", [
                        'event_id' => $eventId,
                    ]);
                } else {
                    $user = User::where('email', $customerEmail)->first();

                    if (! $user) {
                        Log::warning("Received {$eventType} webhook for unknown email: {$customerEmail}", [
                            'event_id' => $eventId,
                        ]);
                    } else {
                        // FIX D: payment.failed — log and update WebhookLog, do NOT credit
                        if ($eventType === 'payment.failed') {
                            $this->webhookLog->update([
                                'payload' => array_merge($payload, ['failed_payment' => true]),
                            ]);
                            Log::info("Dodo payment.failed received for user {$user->id}; no credits granted.", [
                                'event_id' => $eventId,
                                'amount' => $amount,
                            ]);
                        }

                        // FIX B + existing: Handle payment.succeeded with expanded price tiers
                        if ($eventType === 'payment.succeeded') {
                            // FIX: Better mapping that supports test prices and product IDs if available
                            $productId = $payload['data']['product_cart'][0]['product_id'] ?? null;
                            $creditsToAdd = match ((int) $amount) {
                                999 => 1,    // Solo
                                799 => 1,    // Starter pack
                                2599 => 3,   // Growth
                                1999 => 3,   // Pro pack
                                6999 => 10,  // Scale
                                4999 => 10,  // Business pack
                                9999 => 25,  // Agency Pro pack
                                default => app()->environment('local') ? 1 : 0, // Fallback to 1 credit in local test mode
                            };

                            // Override with product ID if available in payload
                            if ($productId) {
                                if ($productId === config('services.dodo.link_1_campaign')) {
                                    $creditsToAdd = 1;
                                }
                                if ($productId === config('services.dodo.link_3_campaigns')) {
                                    $creditsToAdd = 3;
                                }
                                if ($productId === config('services.dodo.link_10_campaigns')) {
                                    $creditsToAdd = 10;
                                }
                            }

                            if ($creditsToAdd > 0) {
                                $user->addCampaignCredits(
                                    $creditsToAdd,
                                    'purchase',
                                    "Dodo Payments Purchase ({$amount} cents)",
                                    $eventId,
                                    'dodo_payment',
                                    null
                                );
                            } else {
                                Log::warning("Received payment.succeeded for user {$user->id} with unmapped amount: {$amount}", [
                                    'event_id' => $eventId,
                                ]);
                            }
                        }

                        // FIX C: Handle payment.refunded
                        if ($eventType === 'payment.refunded') {
                            $refundAmount = (int) $amount;

                            // Look up the original purchase in credit_transactions via idempotency_key.
                            // Dodo refund payloads include the original payment_id; we also try the
                            // event_id fallback for older records.
                            $originalPaymentId = $payload['data']['payment_id']
                                ?? $payload['data']['id']
                                ?? $eventId;

                            $originalTransaction = CreditTransaction::where('user_id', $user->id)
                                ->where('type', 'purchase')
                                ->where(function ($q) use ($originalPaymentId) {
                                    $q->where('idempotency_key', $originalPaymentId)
                                        ->orWhere('reference_type', 'dodo_payment')
                                        ->where('reference_id', (string) $originalPaymentId);
                                })
                                ->orderByDesc('created_at')
                                ->first();

                            if ($originalTransaction) {
                                $creditsToRefund = (int) $originalTransaction->amount;

                                // If credits have already been consumed (balance < creditsToRefund),
                                // refundCampaignCredits() will store the negative balance in the
                                // ledger as required, with a warning logged.
                                $user->refundCampaignCredits(
                                    $creditsToRefund,
                                    "Dodo refund of payment {$originalPaymentId} ({$refundAmount} cents)"
                                );
                            } else {
                                // Original transaction not found — try the tier-based refund fallback
                                $fallbackCredits = match ($refundAmount) {
                                    999 => 1,
                                    799 => 1,
                                    2599 => 3,
                                    1999 => 3,
                                    6999 => 10,
                                    4999 => 10,
                                    9999 => 25,
                                    default => 0,
                                };

                                if ($fallbackCredits > 0) {
                                    Log::info("Refund: original transaction not found, using tier-based fallback of {$fallbackCredits} credits.", [
                                        'user_id' => $user->id,
                                        'refund_amount' => $refundAmount,
                                    ]);
                                    $user->refundCampaignCredits(
                                        $fallbackCredits,
                                        "Dodo refund fallback for {$refundAmount} cents (original txn not found)"
                                    );
                                } else {
                                    Log::warning("Refund: no matching transaction and unmapped refund amount for user {$user->id}.", [
                                        'refund_amount' => $refundAmount,
                                        'event_id' => $eventId,
                                    ]);
                                }
                            }
                        }
                    }
                }

                // Mark original log as processed
                $this->webhookLog->update(['processed_at' => now()]);
            }, 3, ['IMMEDIATE']);

        } catch (\Exception $e) {
            $this->webhookLog->update(['payload' => array_merge($this->webhookLog->payload, ['last_exception' => $e->getMessage()])]);
            throw $e;
        }
    }

    /**
     * Handle a job failure (after all retries are exhausted).
     * Prevents "ghost webhook" syndrome by logging the permanent failure.
     */
    public function failed(\Throwable $exception): void
    {
        $this->webhookLog->update([
            'processed_at' => now(),
            'payload' => array_merge($this->webhookLog->payload, [
                'permanently_failed' => true,
                'final_exception' => Str::limit($exception->getMessage(), 250),
            ]),
        ]);
    }
}
