<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Paddle\Billable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use Billable, HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin === true;
    }

    // CRITICAL: Explicitly guard against mass assignment escalation.
    protected $guarded = [
        'id',
        'is_admin',
        'remember_token',
        'email_verified_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'timezone',
        'campaign_credits',
        'has_used_demo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'campaign_credits' => 'integer',
            'has_used_demo' => 'boolean',
        ];
    }

    /**
     * Mark that this user has consumed their one-time free demo campaign.
     * Called by the chunk job when the first demo campaign is generated.
     */
    public function markDemoUsed(): bool
    {
        if ($this->has_used_demo) {
            return false;
        }

        return (bool) $this->update(['has_used_demo' => true]);
    }

    /**
     * Can this user still generate a free demo campaign?
     * (No credits AND has not used their one-time demo)
     */
    public function canUseFreeDemo(): bool
    {
        return ! $this->has_used_demo && ! $this->hasCampaignCredits();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function ledgers()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function hasCampaignCredits(int $amount = 1): bool
    {
        return $this->campaign_credits >= $amount;
    }

    public function addCampaignCredits(
        int $amount,
        string $type = 'purchase',
        string $description = 'Credits added',
        ?string $idempotencyKey = null,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $ipAddress = null,
        ?string $userAgent = null,
        array $metadata = [],
    ): void {
        if ($amount <= 0) {
            return;
        }

        DB::transaction(function () use ($amount, $type, $description, $idempotencyKey, $referenceType, $referenceId, $ipAddress, $userAgent, $metadata) {
            $this->increment('campaign_credits', $amount);

            $this->ledgers()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $this->campaign_credits,
                'description' => $description,
                'idempotency_key' => $idempotencyKey ?? (string) Str::uuid(),
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'metadata' => $metadata ?: null,
            ]);
        });
    }

    public function decrementCampaignCredit(string $description = 'Credit consumed', ?string $referenceType = null, ?int $referenceId = null): bool
    {
        return DB::transaction(function () use ($description, $referenceType, $referenceId) {
            $user = self::where('id', $this->id)->lockForUpdate()->first();

            if ($user && $user->campaign_credits >= 1) {
                $user->decrement('campaign_credits');

                $user->ledgers()->create([
                    'type' => 'consumption',
                    'amount' => -1,
                    'balance_after' => $user->campaign_credits,
                    'description' => $description,
                    'idempotency_key' => (string) Str::uuid(),
                    'reference_type' => $referenceType,
                    'reference_id' => $referenceId,
                ]);

                return true;
            }

            return false;
        });
    }

    /**
     * FIX F: Refund campaign credits (e.g. from Dodo payment.refunded webhook).
     *
     * - Atomic: wrapped in DB::transaction with lockForUpdate to prevent races
     *   with concurrent consumption/refund operations.
     * - Fraud-protected: capped at MAX_CAMPAIGN_CREDITS_CAP to prevent an attacker
     *   who triggers many refunds from inflating balances arbitrarily.
     * - Always ledger-recorded: even when credits have already been consumed and
     *   the resulting balance is negative, the refund is recorded as a ledger
     *   entry so the audit trail is complete.
     */
    public const MAX_CAMPAIGN_CREDITS_CAP = 1000;

    public function refundCampaignCredits(int $amount, string $reason = 'Refund'): bool
    {
        if ($amount <= 0) {
            return false;
        }

        return DB::transaction(function () use ($amount, $reason) {
            $user = self::where('id', $this->id)->lockForUpdate()->first();

            if (! $user) {
                return false;
            }

            $currentBalance = (int) $user->campaign_credits;
            $requestedTotal = $currentBalance + $amount;
            $actualAmount = $amount;
            $wasCapped = false;

            // Fraud guard: cap the post-refund balance at MAX_CAMPAIGN_CREDITS_CAP.
            // If the requested refund would push the balance above the cap, we only
            // grant enough credits to reach the cap and log the truncation. The
            // ledger still records the *requested* amount so finance can reconcile.
            if ($requestedTotal > self::MAX_CAMPAIGN_CREDITS_CAP) {
                $actualAmount = max(0, self::MAX_CAMPAIGN_CREDITS_CAP - $currentBalance);
                $wasCapped = true;

                Log::warning('Refund capped to prevent fraud/excess.', [
                    'user_id' => $user->id,
                    'requested_amount' => $amount,
                    'actual_amount' => $actualAmount,
                    'balance_before' => $currentBalance,
                    'cap' => self::MAX_CAMPAIGN_CREDITS_CAP,
                    'reason' => $reason,
                ]);
            }

            // If credits have already been consumed and the requested refund
            // would push the balance negative, we still grant it (record a
            // negative balance in the ledger) so the audit trail is complete
            // and the operator can pursue manual recovery.
            $creditsAlreadyConsumed = $currentBalance < $amount;
            if ($creditsAlreadyConsumed && ! $wasCapped) {
                Log::warning('Refund exceeds current balance — granting negative balance.', [
                    'user_id' => $user->id,
                    'current_balance' => $currentBalance,
                    'requested_amount' => $amount,
                    'reason' => $reason,
                ]);
            }

            if ($actualAmount > 0) {
                $user->increment('campaign_credits', $actualAmount);
            }

            $user->ledgers()->create([
                'type' => 'refund',
                'amount' => $actualAmount,
                'balance_after' => $user->campaign_credits,
                'description' => $reason.($wasCapped ? ' (capped at '.self::MAX_CAMPAIGN_CREDITS_CAP.')' : ''),
                'idempotency_key' => (string) Str::uuid(),
                'reference_type' => 'refund',
                'reference_id' => null,
                'metadata' => [
                    'requested_amount' => $amount,
                    'was_capped' => $wasCapped,
                    'credits_already_consumed' => $creditsAlreadyConsumed,
                ],
            ]);

            return true;
        });
    }

    public function getTotalCampaignsCount(): int
    {
        return Campaign::whereHas('project', function ($q) {
            $q->where('user_id', $this->id);
        })->count();
    }
}
