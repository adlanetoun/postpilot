<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::whereHas('project', function($q) use ($request) {
            $q->where('user_id', Auth::id());
        })->with('project')->latest()->get();

        return view('campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        // Check ownership
        if ($campaign->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $project = $campaign->project;
        $posts = $campaign->posts()->orderBy('day_number')->orderBy('platform')->get();

        return view('campaigns.show', compact('campaign', 'project', 'posts'));
    }

    /**
     * Approve the campaign and schedule its posts staggered over 30 days.
     */
    public function approve(Request $request, Campaign $campaign)
    {
        // Check ownership
        if ($campaign->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        // Stagger scheduling logic: start Day 1 tomorrow at 09:00 AM user local time
        // Stagger each platform to avoid concurrent rate limit flags.
        $approved = false;
        DB::transaction(function () use ($campaign, $user, $timezone, &$approved) {
            // SECURITY FIX VULN-3: Atomic status claim inside the transaction.
            // Prevents double-approval if user double-clicks or request is replayed.
            $updated = \App\Models\Campaign::where('id', $campaign->id)
                ->where('status', 'completed')
                ->update(['status' => 'active']);

            if ($updated === 0) {
                return; // Already approved by another request, or not in 'completed' state
            }

            $approved = true;

            $baseDate = now()->timezone($timezone)->startOfDay();

            // Load posts with campaign
            $posts = $campaign->posts;

            // SECURITY FIX VULN-4: Pre-fetch social accounts once to eliminate N+1 queries.
            // Previously: 90 individual queries inside a write-locked transaction.
            $socialAccountsByPlatform = $user->socialAccounts->keyBy('provider');

            foreach ($posts as $post) {
                // Day 1 tomorrow, Day 30 is tomorrow + 29 days
                $postDate = $baseDate->copy()->addDays($post->day_number);

                $baseMinuteOffset = match (strtolower($post->platform)) {
                    'linkedin' => 0,       // 09:00 AM
                    'twitter', 'x' => 15,  // 09:15 AM
                    'facebook' => 30,      // 09:30 AM
                    default => 0,
                };

                // Add random jitter to prevent Thundering Herd API rate limits
                $jitterMinutes = random_int(-10, 10);
                $jitterSeconds = random_int(0, 59);

                $scheduledAt = $postDate->hour(9)
                    ->minute($baseMinuteOffset + $jitterMinutes)
                    ->second($jitterSeconds);

                // Link to user's connected social account for this provider/platform
                $account = $socialAccountsByPlatform[strtolower($post->platform)] ?? null;

                $post->update([
                    'status' => 'approved',
                    'scheduled_at' => $scheduledAt->utc(),
                    'social_account_id' => $account ? $account->id : null,
                ]);
            }
        }, 3, ['IMMEDIATE']);

        if (!$approved) {
            return redirect()->route('dashboard')->with('error', 'Campaign is not ready for approval or was already approved.');
        }

        return redirect()->route('dashboard', ['new' => 1])->with('success', 'Campaign approved! Your 30-day marketing plan is now active and scheduled.');
    }
}
