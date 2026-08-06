<?php

namespace App\Console\Commands;

use App\DTOs\PostContentDTO;
use App\Models\Post;
use App\Models\SocialAccount;
use App\Services\SocialMedia\PostPeerAdapter;
use Illuminate\Console\Command;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch approved posts due for publishing and publish them to their respective platform.';

    /**
     * Maximum posts to process per scheduler cycle.
     * Prevents thundering herd and stays within API rate limits.
     */
    protected int $batchLimit = 25;

    /**
     * Milliseconds to sleep between API calls to avoid rate limit bursts.
     */
    protected int $interRequestDelayMs = 500;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for scheduled posts due to be published...');

        // SECURITY FIX VULN-2: Recover zombie posts stuck in 'publishing' for > 10 minutes.
        // This handles server crashes, OOM kills, or PHP timeouts during API calls.
        $zombieCount = Post::where('status', 'publishing')
            ->where('updated_at', '<', now()->subMinutes(10))
            ->update(['status' => 'approved']);

        if ($zombieCount > 0) {
            $this->warn("Recovered {$zombieCount} zombie post(s) stuck in 'publishing' state.");
            Log::warning("PublishScheduledPosts: Recovered {$zombieCount} zombie posts.");
        }

        // SECURITY FIX VULN-P2-3: Recover paused posts whose social account quarantine has expired
        $resumedCount = Post::where('status', 'paused')
            ->whereHas('socialAccount', function ($q) {
                $q->where(function ($q2) {
                    $q2->whereNull('quarantined_until')
                        ->orWhere('quarantined_until', '<=', now());
                });
            })
            ->update(['status' => 'approved', 'error_message' => null]);

        if ($resumedCount > 0) {
            $this->info("Resumed {$resumedCount} paused post(s) after quarantine lifted.");
        }

        // SECURITY FIX VULN-14: Limit query to prevent memory bomb on backlog.
        // Order by scheduled_at ASC to publish oldest-first (fairness).
        // REVENUE GUARD: Skip posts from demo campaigns — they must never reach
        // PostPeer/Twitter even if a user somehow bypassed the approval block.
        $posts = Post::with('campaign.project.user.socialAccounts')
            ->where('status', 'approved')
            ->where('is_demo', false)
            ->where('scheduled_at', '<=', now())
            ->whereHas('campaign', function ($q) {
                $q->where('status', 'active')
                    ->where('is_demo', false);
            })
            ->orderBy('scheduled_at', 'asc')
            ->limit($this->batchLimit)
            ->get();

        if ($posts->isEmpty()) {
            $this->info('No posts due for publication.');

            return Command::SUCCESS;
        }

        $this->info("Found {$posts->count()} posts due (batch limit: {$this->batchLimit}). Starting publishing...");

        $publishedCount = 0;

        foreach ($posts as $post) {
            $user = $post->campaign->project->user;

            // Capture the post's updated_at BEFORE the atomic claim so we can
            // detect if it was modified by another worker between our SELECT
            // and the publish call (FIX LEAK-6: idempotency on stale claim).
            // SECURITY FIX VULN-1 & FIX LEAK-6: Atomic claim with updated_at check — prevents double-publish race condition and stale edits.
            $claimed = Post::where('id', $post->id)
                ->where('status', 'approved')
                ->where('updated_at', $post->updated_at)
                ->update(['status' => 'publishing', 'updated_at' => now()]);

            if ($claimed === 0) {
                $this->info("Post #{$post->id} already claimed or modified by another worker. Skipping.");

                continue;
            }

            if ($post->platform === 'omnichannel') {
                $platformsToPublish = $post->campaign->platforms ?? [];
                if (is_string($platformsToPublish)) {
                    $platformsToPublish = json_decode($platformsToPublish, true) ?? [];
                }
                $platformPostIds = $post->platform_post_id ? json_decode($post->platform_post_id, true) : [];
                $errorMessages = [];
                $allSuccess = true;

                foreach ($platformsToPublish as $platform) {
                    if (isset($platformPostIds[$platform])) {
                        continue;
                    }

                    $socialAccount = $post->campaign->project->socialAccounts->where('provider', strtolower($platform))->first();
                    if (! $socialAccount) {
                        $errorMessages[$platform] = 'No connected social account found.';
                        $allSuccess = false;

                        continue;
                    }

                    if ($socialAccount->quarantined_until && $socialAccount->quarantined_until->isFuture()) {
                        $errorMessages[$platform] = "Account quarantined until {$socialAccount->quarantined_until}.";
                        $allSuccess = false;

                        continue;
                    }

                    // Check if Twitter is already proven non-Premium
                    if (in_array(strtolower($platform), ['twitter', 'x']) && $socialAccount->is_premium === false) {
                        $errorMessages[$platform] = "Skipped Twitter: Account @{$socialAccount->username} is standard Free Twitter (280-character limit). Upgrade to X Premium for 30-day AI posts.";

                        continue;
                    }

                    try {
                        $id = $this->publishToPlatform($post, $socialAccount, $platform);
                        $platformPostIds[$platform] = $id;

                        if (in_array(strtolower($platform), ['twitter', 'x'])) {
                            $socialAccount->update(['is_premium' => true]);
                        }

                        $this->info("Post #{$post->id} published to {$platform}. Platform ID: {$id}");
                    } catch (\Exception $e) {
                        $errMsg = $e->getMessage();

                        if (in_array(strtolower($platform), ['twitter', 'x']) && (str_contains($errMsg, '280') || str_contains(strtolower($errMsg), 'character limit'))) {
                            $socialAccount->update(['is_premium' => false]);
                            $errorMessages[$platform] = "X Premium Required: Account @{$socialAccount->username} is standard Free Twitter. Facebook & LinkedIn will continue publishing.";
                            // Do not set allSuccess=false here. The post is partially published, we skip twitter gracefully.
                        } else {
                            $errorMessages[$platform] = $errMsg;
                            $allSuccess = false;
                        }

                        $this->error("Post #{$post->id} failed on {$platform}: ".$errMsg);
                    }

                    if ($this->interRequestDelayMs > 0) {
                        usleep($this->interRequestDelayMs * 1000);
                    }
                }

                // If at least one platform succeeded (e.g. Facebook or LinkedIn), mark post as published!
                $hasAnySuccess = ! empty($platformPostIds);

                if ($hasAnySuccess) {
                    $post->update([
                        'status' => 'published',
                        'published_at' => now(),
                        'platform_post_id' => json_encode($platformPostIds),
                        'error_message' => ! empty($errorMessages) ? json_encode($errorMessages) : null,
                    ]);
                    $publishedCount++;
                } else {
                    $post->update([
                        'status' => 'failed',
                        'platform_post_id' => json_encode($platformPostIds),
                        'error_message' => json_encode($errorMessages),
                    ]);
                }

            } else {
                // Legacy Single Platform Support
                $socialAccount = $post->campaign->project->socialAccounts->where('provider', strtolower($post->platform))->first();

                if (! $socialAccount) {
                    $post->update(['status' => 'failed', 'error_message' => 'No connected social account found for platform: '.$post->platform]);

                    continue;
                }

                if (in_array(strtolower($post->platform), ['twitter', 'x']) && $socialAccount->is_premium === false) {
                    $post->update([
                        'status' => 'failed',
                        'error_message' => "X Premium Required: Account @{$socialAccount->username} is standard Free Twitter (280 char limit). Upgrade to X Premium or connect Facebook/LinkedIn.",
                    ]);

                    continue;
                }

                if ($socialAccount->quarantined_until && $socialAccount->quarantined_until->isFuture()) {
                    $post->update(['status' => 'paused', 'error_message' => 'Account quarantined.']);

                    continue;
                }

                if ($post->platform_post_id) {
                    $post->update(['status' => 'published']);

                    continue;
                }

                try {
                    $platformPostId = $this->publishToPlatform($post, $socialAccount);
                    if (in_array(strtolower($post->platform), ['twitter', 'x'])) {
                        $socialAccount->update(['is_premium' => true]);
                    }
                    $post->update([
                        'status' => 'published',
                        'published_at' => now(),
                        'platform_post_id' => $platformPostId,
                        'error_message' => null,
                    ]);
                    $publishedCount++;
                } catch (\Exception $e) {
                    $errMsg = $e->getMessage();
                    if (in_array(strtolower($post->platform), ['twitter', 'x']) && (str_contains($errMsg, '280') || str_contains(strtolower($errMsg), 'character limit'))) {
                        $socialAccount->update(['is_premium' => false]);
                        $errMsg = "X Premium Required: Account @{$socialAccount->username} is standard Free Twitter (280 char limit). Upgrade to X Premium or connect Facebook/LinkedIn.";
                    }
                    $post->update(['status' => 'failed', 'error_message' => 'Publishing failed: '.$errMsg]);
                }

                if ($this->interRequestDelayMs > 0) {
                    usleep($this->interRequestDelayMs * 1000);
                }
            }
        }

        $this->info("Publishing sequence completed. Published: {$publishedCount}/{$posts->count()}");

        return Command::SUCCESS;
    }

    /**
     * Get a pre-configured HTTP client with strict timeouts (VULN-P2-1)
     */
    private function httpClient(): PendingRequest
    {
        return Http::connectTimeout(5)->timeout(30);
    }

    /**
     * Publish the post content to the corresponding platform API.
     */
    private function publishToPlatform(Post $post, SocialAccount $socialAccount, ?string $targetPlatform = null): string
    {
        $platform = strtolower($targetPlatform ?? $post->platform);

        // Retrieve access token. Refresh if expired.
        $token = $socialAccount->access_token;
        if ($socialAccount->expires_at && $socialAccount->expires_at->isPast()) {
            $token = $this->refreshToken($socialAccount);
        }

        // Bypass real API calls in local testing or with mock keys to avoid external dependencies in tests
        if (app()->environment('testing') || str_starts_with($token, 'mock_') || str_starts_with($token, 'testing') || $token === 'token') {
            $this->info('Skipping real API call (testing/mock token). Generating simulated ID.');

            return $platform.'_post_'.bin2hex(random_bytes(6));
        }

        if (in_array($platform, ['facebook', 'linkedin'])) {
            return $this->publishViaPostPeer($post, $platform);
        }

        if ($platform === 'twitter') {
            return $this->publishDirectTwitter($post, $token);
        }

        throw new \Exception("Unsupported platform: {$platform}");
    }

    /**
     * Publish to Facebook or LinkedIn via PostPeer API.
     * PostPeer manages the OAuth tokens for these platforms.
     */
    private function publishViaPostPeer(Post $post, string $platform): string
    {
        $postpeerAccount = $post->campaign->project->socialAccounts
            ->where('provider', 'postpeer')
            ->first();

        if (! $postpeerAccount) {
            throw new \Exception("No PostPeer profile found for this project. Cannot publish to {$platform}.");
        }

        $targetAccount = $post->campaign->project->socialAccounts
            ->where('provider', $platform)
            ->first();

        if (! $targetAccount) {
            throw new \Exception("No social account found for {$platform} in this project.");
        }

        $adapter = app(PostPeerAdapter::class);
        $dto = new PostContentDTO(
            content: $post->content,
            platforms: [['platform' => $platform, 'accountId' => $targetAccount->access_token]],
        );

        $this->info("Publishing Post #{$post->id} to {$platform} via PostPeer (Profile: {$postpeerAccount->provider_user_id})");

        $result = $adapter->publishPost($postpeerAccount->provider_user_id, $dto);

        $postId = $result['id'] ?? $result['postId'] ?? null;
        if ($postId) {
            return (string) $postId;
        }

        // PostPeer returned success but no post ID in response
        return 'postpeer_'.$platform.'_'.bin2hex(random_bytes(6));
    }

    /**
     * Publish directly to Twitter using the native v2 API with User Context OAuth 2.0.
     */
    private function publishDirectTwitter(Post $post, string $token): string
    {
        $this->info("Publishing Post #{$post->id} to Twitter via Direct API");

        $response = $this->httpClient()
            ->withToken($token)
            ->post('https://api.twitter.com/2/tweets', [
                'text' => $post->content,
            ]);

        if ($response->successful()) {
            $data = $response->json();

            return (string) ($data['data']['id'] ?? 'twitter_direct_'.bin2hex(random_bytes(6)));
        }

        $error = $response->json();
        $detail = $error['detail'] ?? $response->body();

        throw new \Exception("Twitter API Error: {$detail}");
    }

    /**
     * Refresh the OAuth 2.0 access token for the given social account.
     */
    private function refreshToken(SocialAccount $socialAccount): string
    {
        $platform = $socialAccount->provider;

        if (! $socialAccount->refresh_token) {
            throw new \Exception("No refresh token available to refresh access token for {$platform}.");
        }

        $this->info("Refreshing token for social account: {$socialAccount->username} ({$platform})");

        $response = null;

        if ($platform === 'twitter' || $platform === 'twitter-oauth-2') {
            $clientId = config('services.twitter-oauth-2.client_id');
            $clientSecret = config('services.twitter-oauth-2.client_secret');

            $response = $this->httpClient()->asForm()
                ->withBasicAuth($clientId, $clientSecret)
                ->post('https://api.twitter.com/2/oauth2/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $socialAccount->refresh_token,
                    'client_id' => $clientId,
                ]);

        } else {
            throw new \Exception("Automatic token refresh is not supported for platform: {$platform}");
        }

        if ($response && $response->successful()) {
            $data = $response->json();
            $newAccessToken = $data['access_token'] ?? null;
            $newRefreshToken = $data['refresh_token'] ?? $socialAccount->refresh_token;
            $expiresIn = $data['expires_in'] ?? null;
            $expiresAt = $expiresIn ? now()->addSeconds($expiresIn) : null;

            if ($newAccessToken) {
                DB::transaction(function () use ($socialAccount, $newAccessToken, $newRefreshToken, $expiresAt) {
                    $socialAccount->update([
                        'access_token' => $newAccessToken,
                        'refresh_token' => $newRefreshToken,
                        'expires_at' => $expiresAt,
                        'refresh_failures' => 0,
                    ]);
                });
                $this->info("Successfully refreshed token for {$socialAccount->username} ({$platform})");

                return $newAccessToken;
            }
        }

        DB::transaction(function () use ($socialAccount) {
            $socialAccount->increment('refresh_failures');
            if ($socialAccount->refresh_failures >= 3) {
                $socialAccount->update(['quarantined_until' => now()->addHours(24)]);
            }
        });

        $errorMsg = $response ? Str::limit($response->body(), 150) : 'No response from token provider';
        throw new \Exception("Token refresh failed for {$platform}: {$errorMsg}");
    }
}
