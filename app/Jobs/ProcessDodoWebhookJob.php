<?php

namespace App\Jobs;

use App\Models\ProcessedWebhook;
use App\Models\WebhookLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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

        // STRICT ALLOW-LIST: Only process financial state changes
        $allowedEvents = [
            'payment.success', 
            'subscription.created', 
            'subscription.updated', 
            'subscription.cancelled', 
            'subscription.refunded'
        ];
        
        if (!in_array($eventType, $allowedEvents, true)) {
            $this->webhookLog->update(['processed_at' => now(), 'payload' => array_merge($payload, ['ignored' => true])]);
            return; // Silently ignore non-financial events
        }

        try {
            // Use IMMEDIATE transaction for safe processing without SQLite lock upgrades
            DB::transaction(function () use ($payload, $eventType) {
                // Idempotency Check using the event ID from payload (Dodo uses 'event_id' or 'id')
                $eventId = $payload['event_id'] ?? $payload['id'] ?? $this->webhookLog->id;
                
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

                // Update User Subscription State
                $customerEmail = $payload['data']['customer']['email'] ?? null;
                if ($customerEmail) {
                    $user = \App\Models\User::where('email', $customerEmail)->first();
                    
                    if ($user) {
                        $status = match($eventType) {
                            'subscription.cancelled', 'subscription.refunded' => 'canceled',
                            default => 'active',
                        };

                        $user->subscription()->updateOrCreate(
                            [], // Search only by user_id to guarantee ONE row per user
                            [
                                'dodo_subscription_id' => $payload['data']['subscription_id'] ?? $payload['data']['subscription']['subscription_id'] ?? uniqid(),
                                'status' => $status,
                                'dodo_customer_id' => $payload['data']['customer']['customer_id'] ?? '',
                                'plan_name' => $payload['data']['subscription']['plan_name'] ?? 'Premium',
                                'ends_at' => $status === 'canceled' ? now() : null,
                            ]
                        );
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
                'final_exception' => \Illuminate\Support\Str::limit($exception->getMessage(), 250),
            ]),
        ]);
    }
}
