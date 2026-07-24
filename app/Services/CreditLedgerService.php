<?php

namespace App\Services;

use App\Models\CreditTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreditLedgerService
{
    public function __construct(
        private readonly ?Request $request = null,
    ) {}

    /**
     * @return Collection<int, CreditTransaction>
     */
    public function getBalanceHistory(int $userId, int $limit = 50): Collection
    {
        return CreditTransaction::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function getMonthlyUsage(int $userId): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        return (int) CreditTransaction::query()
            ->where('user_id', $userId)
            ->where('type', 'consumption')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');
    }

    public function detectRefundAbuse(int $userId): array
    {
        $windowStart = Carbon::now()->subDays(30);

        $refundCount = CreditTransaction::query()
            ->where('user_id', $userId)
            ->where('type', 'refund')
            ->where('created_at', '>=', $windowStart)
            ->count();

        $flagged = $refundCount > 3;

        return [
            'flagged' => $flagged,
            'refund_count' => $refundCount,
            'window_days' => 30,
            'threshold' => 3,
        ];
    }

    public function getLifetimeValue(int $userId): int
    {
        return (int) CreditTransaction::query()
            ->where('user_id', $userId)
            ->where('amount', '>', 0)
            ->sum('amount');
    }

    public function getChurnRisk(int $userId): array
    {
        $user = User::query()->find($userId);

        if (! $user) {
            return [
                'flagged' => false,
                'reason' => 'user_not_found',
                'days_inactive' => null,
                'remaining_credits' => 0,
            ];
        }

        $lastActivity = CreditTransaction::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->value('created_at');

        $daysInactive = $lastActivity
            ? (int) Carbon::parse($lastActivity)->diffInDays(Carbon::now())
            : (int) Carbon::parse($user->created_at)->diffInDays(Carbon::now());

        $remaining = (int) $user->campaign_credits;
        $flagged = $daysInactive > 14 && $remaining > 0;

        return [
            'flagged' => $flagged,
            'reason' => $flagged ? 'inactive_with_credits' : 'active',
            'days_inactive' => $daysInactive,
            'remaining_credits' => $remaining,
            'threshold_days' => 14,
        ];
    }

    /**
     * @return array{score: string, signals: array<int, string>}
     */
    public function calculateFraudRiskScore(int $userId): array
    {
        $signals = [];

        $refundAbuse = $this->detectRefundAbuse($userId);
        if ($refundAbuse['flagged']) {
            $signals[] = "{$refundAbuse['refund_count']} refunds in last {$refundAbuse['window_days']} days";
        }

        $last30 = Carbon::now()->subDays(30);
        $distinctIps = (int) CreditTransaction::query()
            ->where('user_id', $userId)
            ->where('created_at', '>=', $last30)
            ->whereNotNull('ip_address')
            ->distinct()
            ->count('ip_address');

        if ($distinctIps >= 5) {
            $signals[] = "{$distinctIps} distinct IPs in 30 days";
        }

        $churn = $this->getChurnRisk($userId);
        if ($churn['flagged']) {
            $signals[] = "Inactive {$churn['days_inactive']} days with {$churn['remaining_credits']} credits remaining";
        }

        $score = match (true) {
            count($signals) >= 3 => 'high',
            count($signals) === 2 => 'medium',
            count($signals) === 1 => 'low',
            default => 'low',
        };

        return [
            'score' => $score,
            'signals' => $signals,
        ];
    }

    /**
     * @return array<string, int>
     */
    public function getLifetimeStats(int $userId): array
    {
        $rows = CreditTransaction::query()
            ->where('user_id', $userId)
            ->select('type', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();

        $stats = [
            'purchased' => 0,
            'consumed' => 0,
            'refunded' => 0,
        ];

        foreach ($rows as $row) {
            $value = (int) $row->total;
            match ($row->type) {
                'purchase' => $stats['purchased'] = abs($value),
                'consumption' => $stats['consumed'] = abs($value),
                'refund' => $stats['refunded'] = abs($value),
                default => null,
            };
        }

        $stats['net'] = $stats['purchased'] + $stats['refunded'] - $stats['consumed'];

        return $stats;
    }
}
