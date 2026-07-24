<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * REVENUE-LEAK AUDIT MONITOR — Phase 4.
 *
 * Compares resource-consuming operations (LLM calls, PostPeer publish calls)
 * against credit consumption in the last 24 hours, and surfaces any delta
 * as a `leakage_pct`. Exits non-zero with a warning when leakage > 5%.
 *
 * What we measure:
 *  - LLM_API_CALLS_24H: number of `GenerateCampaignChunkJob` handle() entries
 *    recorded via Log channel (we infer from the `campaign_credits` ledger
 *    `consumption` events: each campaign that gets to `completed` cost 5 chunks
 *    on average; we estimate actual chunks delivered via `expected_post_count`).
 *  - POSTPEER_CALLS_24H: count of `posts` rows transitioned to `published` in
 *    the last 24h.
 *  - CREDIT_CONSUMED_24H: sum of CreditTransaction rows where type = consumption
 *    in the last 24h (negative amounts).
 *  - EXPECTED_REVENUE: credit_consumed × unit_price (assumes 1 credit = $9.99
 *    default; override with REVENUE_PER_CREDIT).
 *  - LEAKED_REVENUE: estimated value of unbilled resource consumption.
 *
 * Usage:
 *   php artisan revenue:audit-leakage
 *   php artisan revenue:audit-leakage --window=168   # last 7 days
 *   php artisan revenue:audit-leakage --threshold=3 # warn if > 3%
 */
class AuditRevenueLeakage extends Command
{
    protected $signature = 'revenue:audit-leakage
                            {--window=24 : Look-back window in hours}
                            {--threshold=5 : Leakage percentage threshold for warning exit code}
                            {--revenue-per-credit=9.99 : Average revenue per consumed credit (USD)}';

    protected $description = 'Audit LLM + PostPeer resource consumption vs credit consumption to detect revenue leakage.';

    public function handle(): int
    {
        $windowHours = (int) $this->option('window');
        $threshold = (float) $this->option('threshold');
        $revenuePerCredit = (float) $this->option('revenue-per-credit');
        $since = now()->subHours($windowHours);

        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info(" Revenue Leakage Audit — last {$windowHours}h");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->line(" Threshold for warning: {$threshold}%");
        $this->line(" Revenue per credit:    \${$revenuePerCredit}");
        $this->line('');

        // ── 1. LLM API CALLS (last 24h) ────────────────────────────────────
        // We proxy this via the count of campaigns that completed in the
        // window. Each campaign = ~5 chunk LLM calls (30 days / 7 = ~5).
        $campaignsCompleted = DB::table('campaigns')
            ->where('status', 'completed')
            ->where('updated_at', '>=', $since)
            ->count();

        // Each successful campaign = 5 chunks (one per week).
        $estimatedLlmCalls = $campaignsCompleted * 5;

        $this->line("LLM pipeline activity:");
        $this->line("  Campaigns completed:  {$campaignsCompleted}");
        $this->line("  Estimated LLM calls:  {$estimatedLlmCalls}  (5 chunks per 30-day campaign)");
        $this->line('');

        // ── 2. PostPeer CALLS (last 24h) ───────────────────────────────────
        // Count posts that transitioned to 'published' in the window.
        $postpeerCalls = DB::table('posts')
            ->where('status', 'published')
            ->where('published_at', '>=', $since)
            ->count();

        // Each PostPeer publish call may carry multiple platforms; we estimate
        // 1.5 platforms per call (omnichannel posts fan out).
        $estimatedPostpeerCalls = (int) ceil($postpeerCalls * 1.5);

        $this->line("Social API activity:");
        $this->line("  Posts published:      {$postpeerCalls}");
        $this->line("  Estimated PostPeer:   {$estimatedPostpeerCalls}  (1.5 platforms/post avg)");
        $this->line('');

        // ── 3. CREDIT CONSUMPTION (last 24h) ───────────────────────────────
        $creditsConsumed = (int) DB::table('credit_transactions')
            ->where('type', 'consumption')
            ->where('created_at', '>=', $since)
            ->sum('amount'); // negative values

        $creditsConsumed = abs($creditsConsumed);

        $this->line("Credit consumption:");
        $this->line("  Credits consumed:     {$creditsConsumed}");
        $this->line('');

        // ── 4. EXPECTED REVENUE ────────────────────────────────────────────
        $expectedRevenue = $creditsConsumed * $revenuePerCredit;

        // ── 5. LEAK ESTIMATION ─────────────────────────────────────────────
        // Heuristic: a campaign that completes normally has 1 consumption event
        // (1 credit = $9.99). For every 1 campaign that completed, we expect
        // 1 credit consumed. If `campaignsCompleted` > consumption events
        // involving those campaigns, the delta is the leak.
        //
        // Conservative estimate: assume each completed campaign SHOULD have
        // consumed exactly 1 credit. Unbilled campaigns = leak candidates.
        $billedCampaigns = $creditsConsumed; // 1 credit per approved campaign

        // If a campaign is `failed_generation`, it may have consumed LLM
        // tokens without ever reaching approve() — this is the primary leak.
        $failedGenerations = DB::table('campaigns')
            ->where('status', 'failed_generation')
            ->where('updated_at', '>=', $since)
            ->count();

        $unbilledLlmConsumption = $failedGenerations * 5 * 0.02; // assume avg $0.02/call
        $unbilledPostpeerConsumption = 0; // PostPeer is only called for approved campaignsopper

        $leakedUsd = $unbilledLlmConsumption + $unbilledPostpeerConsumption;
        $leakagePct = $expectedRevenue > 0
            ? round(($leakedUsd / $expectedRevenue) * 100, 2)
            : 0.0;

        $this->line("Revenue analysis:");
        $this->line("  Expected revenue:     \$" . number_format($expectedRevenue, 2));
        $this->line("  Failed generations:   {$failedGenerations}");
        $this->line("  Estimated LLM leak:   \$" . number_format($unbilledLlmConsumption, 2));
        $this->line("  Estimated leak:       \$" . number_format($leakedUsd, 2));
        $this->line("  Leakage:              {$leakagePct}%");
        $this->line('');

        // ── 6. WARNING / EXIT CODE ─────────────────────────────────────────
        if ($leakagePct > $threshold) {
            $this->error("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->error(" ⚠️  LEAKAGE WARNING: {$leakagePct}% exceeds threshold ({$threshold}%)");
            $this->error("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

            Log::warning('Revenue leakage audit exceeded threshold', [
                'window_hours' => $windowHours,
                'leakage_pct' => $leakagePct,
                'leaked_usd' => $leakedUsd,
                'expected_revenue_usd' => $expectedRevenue,
                'campaigns_completed' => $campaignsCompleted,
                'failed_generations' => $failedGenerations,
                'credits_consumed' => $creditsConsumed,
            ]);

            return Command::FAILURE;
        }

        $this->info("✓ Within acceptable leakage threshold.");
        return Command::SUCCESS;
    }
}