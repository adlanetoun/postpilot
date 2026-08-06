<?php

namespace App\Http\Controllers;

use App\Contracts\SocialMediaPublisherInterface;
use App\Models\Campaign;
use App\Models\Project;
use App\Models\SocialAccount;
use App\Services\SocialMedia\PostPeerAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialConnectionController extends Controller
{
    public function __construct(
        protected SocialMediaPublisherInterface $publisher
    ) {}

    /**
     * Redirect the user to PostPeer's OAuth flow for the given platform.
     */
    public function connect(Request $request, Project $project, string $platform)
    {
        // Authorization check
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Verify signed URL to prevent CSRF on GET-based connect
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        $validPlatforms = ['linkedin', 'twitter', 'facebook'];
        if (! in_array($platform, $validPlatforms)) {
            abort(400, 'Invalid platform.');
        }

        // Step 1: Handle Direct Integration platforms (e.g. Twitter via Socialite)
        if ($platform === 'twitter') {
            return redirect()->signedRoute('social-accounts.connect-twitter', ['project' => $project->id]);
        }

        // Step 1.5: Ensure this project has a PostPeer profile
        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();

        if (! $postpeerAccount) {
            try {
                $adapter = $this->resolveAdapter();
                $profileId = $adapter->createProfile($project->name.' - '.Str::random(6));

                $postpeerAccount = $project->socialAccounts()->create([
                    'user_id' => Auth::id(),
                    'provider' => 'postpeer',
                    'provider_user_id' => $profileId,
                    'username' => 'PostPeer Profile',
                    'access_token' => 'managed_by_postpeer',
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create PostPeer profile', ['error' => $e->getMessage()]);

                return view('socials.popup-callback', [
                    'status' => 'error',
                    'message' => 'Failed to initialize social media connection. Please try again.',
                ]);
            }
        }

        $providerProfileId = $postpeerAccount->provider_user_id;

        // Step 1.5: Clean up any orphaned integrations for this platform in PostPeer.
        // Since the user is clicking "Connect", they want to start fresh.
        // If an old integration exists (e.g. they abandoned the flow previously), it will cause the
        // polling `checkStatus` to instantly return false positives.
        try {
            $adapter = $this->resolveAdapter();
            $integrations = $adapter->getIntegrations($providerProfileId);
            foreach ($integrations as $integration) {
                if (($integration['platform'] ?? '') === $platform) {
                    $adapter->deleteIntegration($integration['id']);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to clean up orphaned integrations before connect', ['error' => $e->getMessage()]);
        }

        // Step 2: Generate the PostPeer OAuth connect URL
        // NOTE: PostPeer does NOT support redirectUrl — it always shows JSON after OAuth.
        // We handle this via polling from the parent window (checkStatus endpoint).
        try {
            $adapter = $this->resolveAdapter();
            $connectUrl = $adapter->generateConnectUrl($providerProfileId, $platform);
        } catch (\Exception $e) {
            Log::error('Failed to generate connect URL', ['error' => $e->getMessage()]);

            return view('socials.popup-callback', [
                'status' => 'error',
                'message' => 'Failed to start the connection process. Please try again.',
            ]);
        }

        return redirect()->away($connectUrl);
    }

    /**
     * Render the bridge popup page that manages OAuth in a child window
     * and auto-closes both windows upon completion.
     */
    public function connectPopup(Request $request, Project $project, string $platform)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        $validPlatforms = ['linkedin', 'twitter', 'facebook'];
        if (! in_array($platform, $validPlatforms)) {
            abort(400, 'Invalid platform.');
        }

        // Handle Direct Integration platforms (e.g. Twitter via Socialite)
        if ($platform === 'twitter') {
            return redirect()->signedRoute('social-accounts.connect-twitter', ['project' => $project->id]);
        }

        // Ensure this project has a PostPeer profile
        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();

        if (! $postpeerAccount) {
            try {
                $adapter = $this->resolveAdapter();
                $profileId = $adapter->createProfile($project->name.' - '.Str::random(6));

                $postpeerAccount = $project->socialAccounts()->create([
                    'user_id' => Auth::id(),
                    'provider' => 'postpeer',
                    'provider_user_id' => $profileId,
                    'username' => 'PostPeer Profile',
                    'access_token' => 'managed_by_postpeer',
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create PostPeer profile', ['error' => $e->getMessage()]);

                return view('socials.popup-callback', [
                    'status' => 'error',
                    'message' => 'Failed to initialize social media connection. Please try again.',
                ]);
            }
        }

        $providerProfileId = $postpeerAccount->provider_user_id;

        // Clean up any orphaned integrations for this platform in PostPeer
        try {
            $adapter = $this->resolveAdapter();
            $integrations = $adapter->getIntegrations($providerProfileId);
            foreach ($integrations as $integration) {
                if (($integration['platform'] ?? '') === $platform) {
                    $adapter->deleteIntegration($integration['id']);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to clean up orphaned integrations before connect', ['error' => $e->getMessage()]);
        }

        // Generate the PostPeer OAuth connect URL
        try {
            $adapter = $this->resolveAdapter();
            $connectUrl = $adapter->generateConnectUrl($providerProfileId, $platform);
        } catch (\Exception $e) {
            Log::error('Failed to generate connect URL', ['error' => $e->getMessage()]);

            return view('socials.popup-callback', [
                'status' => 'error',
                'message' => 'Failed to start the connection process. Please try again.',
            ]);
        }

        return view('socials.connect-popup', [
            'project' => $project,
            'platform' => $platform,
            'connectUrl' => $connectUrl,
        ]);
    }

    /**
     * Disconnect a social account from a project.
     * Cleans up both our DB record AND the PostPeer integration.
     */
    public function disconnect(Request $request, Project $project, string $platform)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $hasActiveCampaign = Campaign::where('project_id', $project->id)
            ->whereIn('status', ['active', 'paused', 'generating'])
            ->exists();

        if ($hasActiveCampaign) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Cannot disconnect '.ucfirst($platform).' while there is an active, paused, or generating campaign.');
        }

        $account = $project->socialAccounts()->where('provider', $platform)->first();
        if (! $account) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Account not found.');
        }

        // FIX Bug #2: Delete from PostPeer by querying its API directly,
        // instead of relying on the possibly-stale access_token field.
        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();
        if ($postpeerAccount) {
            try {
                $adapter = $this->resolveAdapter();
                $integrations = $adapter->getIntegrations($postpeerAccount->provider_user_id);

                foreach ($integrations as $integration) {
                    // Find the integration matching this platform
                    if (($integration['platform'] ?? '') === $platform) {
                        $adapter->deleteIntegration($integration['id']);
                        Log::debug('Deleted PostPeer integration', [
                            'integration_id' => $integration['id'],
                            'platform' => $platform,
                            'project_id' => $project->id,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Log but don't block — DB cleanup should still happen
                Log::warning('Failed to delete PostPeer integration', ['error' => $e->getMessage()]);
            }
        }

        $account->delete();

        return redirect()->route('projects.show', $project->id)
            ->with('success', ucfirst($platform).' account disconnected successfully.');
    }

    /**
     * Poll PostPeer API to check if integrations were connected for this project.
     *
     * UPDATED: Instead of auto-saving all integrations, returns needs_selection
     * so the parent window can redirect to the page selection screen.
     */
    public function checkStatus(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            return response()->json(['connected' => [], 'rejected' => []]);
        }

        // Check local DB for direct integration platforms (e.g. Twitter)
        $directConnected = [];
        if (SocialAccount::where('project_id', $project->id)->where('provider', 'twitter')->exists()) {
            $directConnected[] = 'twitter';
        }

        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();
        if (! $postpeerAccount) {
            return response()->json(['connected' => $directConnected, 'rejected' => []]);
        }

        $profileId = $postpeerAccount->provider_user_id;
        $adapter = $this->resolveAdapter();

        try {
            $integrations = $adapter->getIntegrations($profileId);
        } catch (\Exception $e) {
            // If the API is slow/timing out, just return empty so polling can try again later
            // without spamming the error logs with 500 errors.
            return response()->json(['connected' => [], 'rejected' => [], 'needs_selection' => []]);
        }

        $confirmedConnected = $directConnected;
        $rejected = [];
        $needsSelection = [];

        foreach ($integrations as $integration) {
            $platform = $integration['platform'] ?? null;
            $platformUserId = $integration['platformUserId'] ?? null;
            $integrationId = $integration['id'] ?? null;

            if (! $platform || ! $platformUserId) {
                continue;
            }

            // SECURITY CHECK: Is this specific social page already connected to ANOTHER project?
            $alreadyUsedByOther = SocialAccount::where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->where('project_id', '!=', $project->id)
                ->exists();

            if ($alreadyUsedByOther) {
                // VULNERABILITY PREVENTION: Delete from PostPeer and reject
                if ($integrationId) {
                    try {
                        $adapter->deleteIntegration($integrationId);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete duplicate integration', ['error' => $e->getMessage()]);
                    }
                }
                $rejected[] = $platform;

                continue;
            }

            // Check if this integration is ALREADY saved in our DB
            $existing = $project->socialAccounts()
                ->where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->first();

            if ($existing) {
                // Already connected — just confirm
                if ($integrationId && $existing->access_token !== $integrationId) {
                    $existing->update(['access_token' => $integrationId]);
                }
                $confirmedConnected[] = $platform;
            } else {
                // NEW integration detected — needs page selection
                // Don't auto-save; let the user choose via select-page screen
                if (! in_array($platform, $needsSelection)) {
                    $needsSelection[] = $platform;
                }
            }
        }

        return response()->json([
            'connected' => $confirmedConnected,
            'rejected' => $rejected,
            'needs_selection' => $needsSelection,
        ]);
    }

    /**
     * Display the page selection screen for a given platform.
     * Fetches available pages/integrations from PostPeer and shows them
     * so the user can choose exactly ONE page for this project.
     */
    public function selectPage(Request $request, Project $project, string $platform)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();
        if (! $postpeerAccount) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'No PostPeer profile found. Please try connecting again.');
        }

        $adapter = $this->resolveAdapter();

        try {
            $integrations = $adapter->getIntegrations($postpeerAccount->provider_user_id);
        } catch (\Exception $e) {
            Log::warning('PostPeer getIntegrations timeout in selectPage', ['error' => $e->getMessage()]);

            return redirect()->route('projects.show', $project->id)
                ->with('error', 'The connection to PostPeer timed out. The platform might be experiencing high traffic. Please try again.');
        }

        // Filter integrations for the requested platform only
        $pages = [];
        foreach ($integrations as $integration) {
            if (($integration['platform'] ?? '') !== $platform) {
                continue;
            }

            $platformUserId = $integration['platformUserId'] ?? null;

            // Skip pages already connected to OTHER projects
            $alreadyUsedByOther = SocialAccount::where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->where('project_id', '!=', $project->id)
                ->exists();

            if ($alreadyUsedByOther) {
                continue;
            }

            // Skip pages already saved in THIS project
            $alreadySaved = $project->socialAccounts()
                ->where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->exists();

            if ($alreadySaved) {
                continue;
            }

            $pages[] = [
                'name' => $integration['displayName'] ?? ucfirst($platform).' Page',
                'logo_url' => $integration['imageUrl'] ?? null,
                'provider_user_id' => $platformUserId,
                'integration_id' => $integration['id'] ?? null,
                'profile_url' => $integration['profileUrl'] ?? null,
                'is_personal' => ($integration['username'] ?? null) === null && ($integration['platformMetadata'] ?? null) === null,
            ];
        }

        // Generate a CSRF-like state token to prevent replay attacks on savePage
        $state = Str::random(40);
        session()->put("social_select_state_{$project->id}_{$platform}", $state);

        $isPopup = $request->query('popup') == '1';

        return view('socials.select-page', [
            'project' => $project,
            'platform' => $platform,
            'pages' => $pages,
            'state' => $state,
            'isPopup' => $isPopup,
        ]);
    }

    /**
     * Save the user's single page selection and clean up unselected pages from PostPeer.
     */
    public function savePage(Request $request, Project $project, string $platform)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate state token
        $expectedState = session()->pull("social_select_state_{$project->id}_{$platform}");
        if (! $expectedState || $request->input('state') !== $expectedState) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Invalid or expired session. Please try connecting again.');
        }

        $selectedIndex = (int) $request->input('selected_page_index', 0);

        $postpeerAccount = $project->socialAccounts()->where('provider', 'postpeer')->first();
        if (! $postpeerAccount) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'No PostPeer profile found.');
        }

        $adapter = $this->resolveAdapter();

        try {
            $integrations = $adapter->getIntegrations($postpeerAccount->provider_user_id);
        } catch (\Exception $e) {
            Log::warning('PostPeer getIntegrations failed during savePage', ['error' => $e->getMessage()]);

            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Connection to PostPeer timed out. Please try connecting again.');
        }

        // Filter to only this platform's integrations (same order as selectPage)
        $platformIntegrations = [];
        foreach ($integrations as $integration) {
            if (($integration['platform'] ?? '') !== $platform) {
                continue;
            }

            $platformUserId = $integration['platformUserId'] ?? null;

            // Skip pages already connected to OTHER projects
            $alreadyUsedByOther = SocialAccount::where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->where('project_id', '!=', $project->id)
                ->exists();

            if ($alreadyUsedByOther) {
                continue;
            }

            // Skip pages already saved in THIS project
            $alreadySaved = $project->socialAccounts()
                ->where('provider', $platform)
                ->where('provider_user_id', $platformUserId)
                ->exists();

            if ($alreadySaved) {
                continue;
            }

            $platformIntegrations[] = $integration;
        }

        if (empty($platformIntegrations) || ! isset($platformIntegrations[$selectedIndex])) {
            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Selected page is no longer available. Please try connecting again.');
        }

        $selectedIntegration = $platformIntegrations[$selectedIndex];

        // Zero API Credit Consumption Mode: Direct OAuth connection without pre-flight API calls
        // PostPeer manages OAuth token storage seamlessly.

        DB::beginTransaction();
        try {
            // Save the selected page to DB
            $project->socialAccounts()->create([
                'user_id' => Auth::id(),
                'provider' => $platform,
                'provider_user_id' => $selectedIntegration['platformUserId'],
                'username' => $selectedIntegration['displayName'] ?? ucfirst($platform).' via PostPeer',
                'access_token' => $selectedIntegration['id'] ?? 'managed_by_postpeer',
                'scopes' => '',
            ]);

            // Delete all OTHER integrations for this platform from PostPeer (keep only selected)
            foreach ($platformIntegrations as $index => $integration) {
                if ($index === $selectedIndex) {
                    continue; // Keep the selected one
                }

                $integrationId = $integration['id'] ?? null;
                if ($integrationId) {
                    try {
                        $adapter->deleteIntegration($integrationId);
                        Log::debug('Deleted unselected PostPeer integration', [
                            'integration_id' => $integrationId,
                            'platform' => $platform,
                            'project_id' => $project->id,
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete unselected integration', ['error' => $e->getMessage()]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save selected page', ['error' => $e->getMessage()]);

            return redirect()->route('projects.show', $project->id)
                ->with('error', 'Failed to complete the connection. Please try again.');
        }

        Log::info('Page selected and saved', [
            'platform' => $platform,
            'page_name' => $selectedIntegration['displayName'] ?? 'unknown',
            'project_id' => $project->id,
        ]);

        if ($request->input('popup') == '1') {
            // The popup should close itself. The main window's polling will detect CASE 3 and reload.
            return response()->setContent("
                <html>
                <body>
                    <script>
                        // Try to close normally
                        window.close();
                        // If that fails, show a fallback message
                        document.body.innerHTML = '<h2 style=\"font-family:sans-serif;text-align:center;margin-top:20vh;\">Success! You can close this window now.</h2>';
                    </script>
                </body>
                </html>
            ");
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', ucfirst($platform).' page connected successfully!');
    }

    /**
     * Resolve the PostPeerAdapter from behind the QuotaEnforcerDecorator.
     */
    private function resolveAdapter(): PostPeerAdapter
    {
        if ($this->publisher instanceof PostPeerAdapter) {
            return $this->publisher;
        }

        // Behind QuotaEnforcerDecorator or any other decorator
        return app(PostPeerAdapter::class);
    }
}
