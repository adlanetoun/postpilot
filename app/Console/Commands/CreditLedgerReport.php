<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\CreditLedgerService;
use Illuminate\Console\Command;

class CreditLedgerReport extends Command
{
    protected $signature = 'credits:ledger-report
                            {--user-id= : Report for a single user ID}
                            {--days=30 : Lookback window for fraud signals}';

    protected $description = 'Audit credit ledger: purchases, consumption, refunds, churn risk, and fraud score.';

    public function handle(CreditLedgerService $ledger): int
    {
        $days = (int) $this->option('days');
        $userId = $this->option('user-id');

        $users = $userId
            ? User::query()->where('id', $userId)->get()
            : User::query()->orderBy('id')->get();

        if ($users->isEmpty()) {
            $this->warn('No users found.');

            return Command::SUCCESS;
        }

        $rows = [];
        foreach ($users as $user) {
            $stats = $ledger->getLifetimeStats($user->id);
            $fraud = $ledger->calculateFraudRiskScore($user->id);

            $lastActivity = $user->ledgers()->orderByDesc('created_at')->value('created_at');

            $rows[] = [
                'user_id' => $user->id,
                'email' => $user->email,
                'purchased' => $stats['purchased'],
                'consumed' => $stats['consumed'],
                'refunded' => $stats['refunded'],
                'net' => $stats['net'],
                'last_activity' => $lastActivity ? $lastActivity->format('Y-m-d H:i') : 'never',
                'risk' => strtoupper($fraud['score']),
            ];
        }

        $this->info("Credit Ledger Audit (window: {$days} days)");
        $this->line(str_repeat('=', 120));

        $this->table(
            ['User ID', 'Email', 'Purchased', 'Consumed', 'Refunded', 'Net', 'Last Activity', 'Fraud Risk'],
            array_map(fn ($r) => [
                $r['user_id'],
                $r['email'],
                $r['purchased'],
                $r['consumed'],
                $r['refunded'],
                $r['net'],
                $r['last_activity'],
                $r['risk'],
            ], $rows),
        );

        $highRisk = array_filter($rows, fn ($r) => $r['risk'] === 'HIGH');
        if (! empty($highRisk)) {
            $this->error('HIGH RISK USERS DETECTED:');
            foreach ($highRisk as $r) {
                $this->line("  - User #{$r['user_id']} ({$r['email']})");
            }
        }

        return Command::SUCCESS;
    }
}
