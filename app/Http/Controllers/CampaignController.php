<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateCampaignJob;
use App\Models\Campaign;
use App\Models\Project;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::whereHas('project', function ($q) {
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
     * Store a newly created campaign and initiate LLM generation.
     */
    public function store(Request $request, Project $project)
    {
        // Check ownership
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();

        // SECURITY FIX: Prevent Race Conditions (Double-Click Bug) for Campaign Generation
        $lock = Cache::lock('campaign_generate_project_'.$project->id, 10);
        try {
            $lock->block(5);

            // SECURITY FIX: One-time free demo per account lifetime.
            // After using their single free demo, users must purchase credits.
            if ($user->campaign_credits <= 0 && ! $user->canUseFreeDemo()) {
                return redirect()->route('profile.edit', ['tab' => 'billing', 'error' => 'credits_required'])
                    ->with('error', 'You have already used your one-time free preview. Please purchase campaign credits to generate and publish real campaigns.');
            }

            // SECURITY & UX FIX GAP-5: Prevent creating a new campaign while one is already generating or awaiting approval
            $existingCampaign = $project->campaigns()
                ->whereIn('status', ['generating', 'completed'])
                ->exists();

            if ($existingCampaign) {
                return redirect()->back()
                    ->with('error', 'This project already has a campaign in progress or awaiting approval. Please wait for it to finish or delete the project to start over.');
            }

            $validated = $request->validate([
                // HARD LIMIT: Prevents massive prompt injection payloads
                'description' => 'required|string|max:1500',
                'target_audience' => 'required|string|max:255',
                'value_proposition' => 'nullable|string|max:500',
                'tone_of_voice' => 'nullable|string|max:255',
                'language' => 'required|string|in:English,Arabic,French,Spanish,German',
                'platforms' => 'required|array|min:1|max:3',
                'platforms.*' => 'required|string|distinct|in:linkedin,twitter,facebook',
            ]);

            // Verify that all selected platforms are actually connected to this project
            $connectedPlatforms = $project->socialAccounts->pluck('provider')->toArray();
            foreach ($validated['platforms'] as $selectedPlatform) {
                if (! in_array($selectedPlatform, $connectedPlatforms)) {
                    return redirect()->back()
                        ->withErrors(['platforms' => "The platform '".ucfirst($selectedPlatform)."' is not connected to this project."])
                        ->withInput();
                }
            }

            // CONVERSION BOOST: Calculate value summary to anchor the perceived ROI
            // before the user commits a credit. Frames 1 credit as the price of 30 days
            // of copywriter-grade output, dramatically reducing price-resistance.
            $platformCount = count($validated['platforms']);
            $platformLabels = array_map(function ($p) {
                return match (strtolower($p)) {
                    'linkedin' => 'LinkedIn',
                    'twitter' => 'X',
                    'facebook' => 'Facebook',
                    default => ucfirst($p),
                };
            }, $validated['platforms']);

            $valueSummary = [
                'days' => 30,
                'platforms' => $platformCount,
                'platform_labels' => $platformLabels,
                'posts_per_day' => 1,
                'total_posts' => 30 * $platformCount,
                'hours_saved' => round(30 * $platformCount * 0.15, 1), // ~9 min per post
                'equivalent_value' => 30 * $platformCount * 17,         // ~$17 per post in copywriter fees
                'credit_cost' => 9.99,
            ];
            session()->flash('campaign_value_summary', $valueSummary);

            // Create campaign in generating status
            // SECURITY & UX FIX GAP-4: Sanitize all user campaign fields before they are sent to the LLM prompt
            $campaign = $project->campaigns()->create([
                'status' => 'generating',
                'description' => $this->sanitizeForLlm($validated['description']),
                'target_audience' => $this->sanitizeForLlm($validated['target_audience']),
                'value_proposition' => $this->sanitizeForLlm($validated['value_proposition'] ?? ''),
                'tone_of_voice' => $this->sanitizeForLlm($validated['tone_of_voice'] ?? 'Professional'),
                'language' => $validated['language'],
                'platforms' => $validated['platforms'],
            ]);

            // Dispatch background campaign generation job
            GenerateCampaignJob::dispatch($campaign->id);

            return redirect()->route('projects.show', $project->id)
                ->with('success', 'Campaign created! We are generating your 30-day content plan.');

        } catch (LockTimeoutException $e) {
            return redirect()->back()->with('error', 'System is busy generating a campaign. Please wait.');
        } finally {
            $lock?->release();
        }
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

        // REVENUE GUARD & DEMO UPGRADE: Demo campaigns (free user previews)
        // Convert seamlessly to real AI campaigns if the user owns campaign credits!
        if ($campaign->is_demo) {
            if ($user->campaign_credits < 1) {
                return redirect()->route('profile.edit', ['tab' => 'billing', 'error' => 'demo_upgrade'])
                    ->with('error', 'This is a free preview campaign. To publish to your social channels, please purchase 1 campaign credit to launch your live 30-day AI campaign.');
            }

            // User has 1+ credits! Convert demo campaign to real paid AI campaign!
            $lock = Cache::lock('campaign_action_user_'.$user->id, 10);
            try {
                $lock->block(5);

                $converted = false;
                DB::transaction(function () use ($campaign, $user, &$converted) {
                    if (! $user->decrementCampaignCredit()) {
                        return;
                    }
                    // Remove demo status, set status to generating
                    $campaign->update([
                        'is_demo' => false,
                        'status' => 'generating',
                        'error_message' => null,
                    ]);
                    // Delete demo stub posts
                    $campaign->posts()->delete();
                    $converted = true;
                });

                if ($converted) {
                    // Dispatch real LLM generation job
                    GenerateCampaignJob::dispatch($campaign->id);

                    return redirect()->route('projects.show', $campaign->project_id)
                        ->with('success', '1 Campaign Credit redeemed! We are generating your full 30-day AI campaign and setting up live scheduling.');
                } else {
                    return redirect()->route('profile.edit', ['tab' => 'billing', 'error' => 'credits_required'])
                        ->with('error', 'You need 1 Campaign Credit to publish and schedule this campaign. Please top up your credits.');
                }
            } catch (LockTimeoutException $e) {
                return redirect()->route('projects.show', $campaign->project_id)->with('error', 'System is busy processing another request. Please try again.');
            } finally {
                $lock?->release();
            }
        }

        // SECURITY FIX: Prevent Race Conditions (Double-Click Bug) using Cache Lock
        $lock = Cache::lock('campaign_action_user_'.$user->id, 10);

        try {
            // Block for up to 5 seconds waiting for the lock
            $lock->block(5);

            // Prevent multiple active campaigns per PROJECT (New Rule)
            $hasActiveCampaign = Campaign::where('project_id', $campaign->project_id)
                ->where('id', '!=', $campaign->id)
                ->where('status', 'active')
                ->exists();

            if ($hasActiveCampaign) {
                return redirect()->route('projects.show', $campaign->project_id)->with('error', 'This project already has an active campaign. Please pause or delete it before launching a new one for this project.');
            }

            $timezone = $user->timezone ?? 'UTC';

            // Stagger scheduling logic: start Day 1 tomorrow at 09:00 AM user local time
            // Stagger each platform to avoid concurrent rate limit flags.
            $approved = false;
            $creditDeducted = false;
            $approvalException = null;

            // FIX G: Wrap credit deduction + status claim in try/catch so that if the
            // status update or post scheduling fails AFTER the credit is deducted, we
            // auto-refund the credit instead of silently losing it.
            try {
                DB::transaction(function () use ($campaign, $user, $timezone, &$approved, &$creditDeducted) {
                    // NEW SECURITY FIX: Deduct credit atomically INSIDE the transaction
                    // If the transaction fails, the credit deduction is automatically rolled back.
                    if (! $user->decrementCampaignCredit()) {
                        $creditDeducted = false;

                        return;
                    }
                    $creditDeducted = true;

                    // SECURITY FIX VULN-3: Atomic status claim inside the transaction.
                    // Prevents double-approval if user double-clicks or request is replayed.
                    $updated = Campaign::where('id', $campaign->id)
                        ->where('status', 'completed')
                        ->update(['status' => 'active']);

                    if ($updated === 0) {
                        // FIX G: Previously the credit was lost here. Now we throw so
                        // the outer try/catch can auto-refund.
                        throw new \RuntimeException('Campaign is not ready for approval or was already approved.');
                    }

                    $approved = true;

                    $baseDate = now()->timezone($timezone)->startOfDay();

                    // Load posts with campaign
                    $posts = $campaign->posts;

                    // SECURITY FIX VULN-4: Pre-fetch social accounts once to eliminate N+1 queries.
                    // Using PROJECT-LEVEL accounts as per new architecture
                    $socialAccountsByPlatform = $campaign->project->socialAccounts->keyBy('provider');

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
            } catch (\Throwable $e) {
                // FIX G: Auto-refund the credit if we deducted it but the transaction
                // failed to complete (status claim, scheduling, or DB error).
                if ($creditDeducted && ! $approved) {
                    try {
                        $user->addCampaignCredits(1, 'refund', 'Generation approval failed: '.$e->getMessage());
                    } catch (\Throwable $refundError) {
                        Log::critical('Failed to auto-refund credit after approval failure', [
                            'user_id' => $user->id,
                            'campaign_id' => $campaign->id,
                            'original_error' => $e->getMessage(),
                            'refund_error' => $refundError->getMessage(),
                        ]);
                    }
                }
                $approvalException = $e;
            }

            if ($approvalException instanceof LockTimeoutException) {
                return redirect()->route('projects.show', $campaign->project_id)->with('error', 'System is busy processing another request. Please try again.');
            }

            if (! $creditDeducted) {
                return redirect()->route('profile.edit', ['tab' => 'billing', 'error' => 'credits_required'])
                    ->with('error', 'You need 1 Campaign Credit to publish and schedule this campaign. Please purchase a credit pack.');
            }

            if (! $approved) {
                return redirect()->route('projects.show', $campaign->project_id)->with('error', 'Campaign is not ready for approval or was already approved.');
            }

            return redirect()->route('projects.show', $campaign->project_id)->with('success', 'Campaign approved! Your 30-day marketing plan is now active and scheduled.');
        } catch (LockTimeoutException $e) {
            return redirect()->route('projects.show', $campaign->project_id)->with('error', 'System is busy processing another request. Please try again.');
        } finally {
            $lock?->release();
        }
    }

    /**
     * Pause or resume autopilot for an active campaign.
     */
    public function togglePause(Campaign $campaign)
    {
        // Check ownership
        if ($campaign->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();

        // SECURITY FIX: Prevent Race Conditions (Double-Click Bug) using Cache Lock
        $lock = Cache::lock('campaign_action_user_'.$user->id, 10);

        try {
            $lock->block(5);

            // Fetch fresh status from DB to ensure we don't act on stale in-memory data
            $campaign->refresh();

            if (! in_array($campaign->status, ['active', 'paused'])) {
                return back()->with('error', 'Campaign cannot be paused or resumed in its current state.');
            }

            $newStatus = $campaign->status === 'active' ? 'paused' : 'active';

            // If resuming campaign, shift all remaining unpublished posts forward to prevent thundering herd publishing.
            if ($newStatus === 'active') {
                // Removed subscription check as per new Credit model

                $hasActiveCampaign = Campaign::where('project_id', $campaign->project_id)
                    ->where('id', '!=', $campaign->id)
                    ->where('status', 'active')
                    ->exists();

                if ($hasActiveCampaign) {
                    return back()->with('error', 'This project already has an active campaign. Please pause it before resuming this one.');
                }

                // SECURITY FIX: State Machine validation - Verify platforms are still connected before resuming
                $connectedPlatforms = $campaign->project->socialAccounts()->pluck('provider')->toArray();
                $missingPlatforms = array_diff($campaign->platforms ?? [], $connectedPlatforms);

                if (! empty($missingPlatforms)) {
                    return back()->with('error', 'Cannot resume campaign. You are missing connected accounts for: '.implode(', ', $missingPlatforms).'. Please connect them first.');
                }

                $firstMissedPost = $campaign->posts()
                    ->where('status', 'approved')
                    ->where('scheduled_at', '<', now())
                    ->orderBy('scheduled_at', 'asc')
                    ->first();

                if ($firstMissedPost) {
                    // Calculate days missed (absolute value to shift forward)
                    $daysDifference = $firstMissedPost->scheduled_at->diffInDays(now(), false);
                    $daysToShift = (int) ceil(abs($daysDifference));

                    if ($daysToShift <= 0) {
                        $daysToShift = 1;
                    }

                    $campaign->posts()
                        ->where('status', 'approved')
                        ->each(function ($post) use ($daysToShift) {
                            $post->update([
                                'scheduled_at' => $post->scheduled_at->addDays($daysToShift),
                            ]);
                        });
                }
            }

            $campaign->update(['status' => $newStatus]);

            $msg = $newStatus === 'active' ? 'Campaign resumed. Autopilot publishing is now active.' : 'Campaign paused. Autopilot publishing has been suspended.';

            return back()->with('success', $msg);

        } catch (LockTimeoutException $e) {
            return back()->with('error', 'System is busy processing another request. Please try again.');
        } finally {
            $lock?->release();
        }
    }

    /**
     * Remove the failed or draft campaign to allow reconfiguration.
     * SECURITY & UX FIX UX-1: Allows clearing campaign without losing connected social accounts.
     */
    public function destroy(Campaign $campaign)
    {
        if ($campaign->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $projectId = $campaign->project_id;
        $user = Auth::user();

        // Update status first so any executing queue worker immediately detects cancellation
        if ($campaign->status === 'generating') {
            $campaign->update(['status' => 'cancelled']);
        }

        // ZERO-PUBLISHED CREDIT REFUND PROTECTION:
        // If campaign was active/paused (credit was deducted), but 0 posts have been published yet,
        // refund 1 credit back to the user balance so no credit is lost!
        $refunded = false;
        if (in_array($campaign->status, ['active', 'paused'])) {
            $publishedCount = $campaign->posts()->whereIn('status', ['published', 'publishing'])->count();
            if ($publishedCount === 0) {
                try {
                    $user->addCampaignCredits(1, 'refund', "Refund for deleted campaign #{$campaign->id} with 0 published posts");
                    $refunded = true;
                } catch (\Throwable $e) {
                    Log::error('Failed to refund credit on campaign destroy', ['error' => $e->getMessage()]);
                }
            }
        }

        $campaign->delete();

        $msg = $refunded
            ? 'Campaign deleted. Since no posts were published yet, 1 Campaign Credit has been refunded to your account!'
            : 'Campaign cleared successfully.';

        return redirect()->route('projects.show', $projectId)->with('success', $msg);
    }

    /**
     * Revoke campaign approval and revert all scheduled posts to draft status.
     * Only works if no posts have been published or are publishing.
     */
    public function revokeApproval(Campaign $campaign)
    {
        if ($campaign->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($campaign->status !== 'active' && $campaign->status !== 'paused') {
            return back()->with('error', 'Campaign is not in an active or paused state.');
        }

        // Check if any post has already been published or is publishing
        $hasPublished = $campaign->posts()->whereIn('status', ['published', 'publishing'])->exists();
        if ($hasPublished) {
            return back()->with('error', 'Cannot revoke approval because some posts have already been published.');
        }

        $user = Auth::user();

        DB::transaction(function () use ($campaign, $user) {
            $campaign->update(['status' => 'completed']);
            $campaign->posts()->update([
                'status' => 'draft',
                'scheduled_at' => null,
                'social_account_id' => null,
            ]);

            // Refund 1 credit if 0 posts were published
            $user->addCampaignCredits(1, 'refund', "Refund for revoked approval on campaign #{$campaign->id}");
        });

        return redirect()->route('projects.show', $campaign->project_id)
            ->with('success', 'Campaign approval revoked. Posts reset to draft status and 1 Campaign Credit refunded to your balance!');
    }

    /**
     * SECURITY FIX GAP-4: Sanitize user-provided text before it is interpolated into LLM prompts.
     * Strips control characters and common prompt injection patterns.
     */
    private function sanitizeForLlm(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Strip HTML tags
        $text = strip_tags($text);

        // Remove control characters (keeps newlines and tabs for readability)
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', ' ', $text);

        // Neutralize common prompt injection override patterns
        $text = preg_replace(
            '/\b(ignore|disregard|forget|override|bypass|skip)\s+(all\s+)?(previous|above|prior|earlier|system)\s+(instructions|prompts|rules|context)/i',
            '[FILTERED]',
            $text
        );

        // Neutralize "system:" or "assistant:" role injection
        $text = preg_replace('/^(system|assistant|user)\s*:/im', '[FILTERED]:', $text);

        return Str::limit($text, 1500, '');
    }
}
