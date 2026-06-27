<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAccountController extends Controller
{
    /**
     * Redirect to the OAuth provider's gateway.
     */
    public function connect(Request $request, string $platform)
    {
        if (config('app.oauth_debug', false)) {
            \Illuminate\Support\Facades\Log::debug('SocialAccountController::connect hit!', [
                'platform' => $platform,
                'user_id' => Auth::id(),
                'url' => $request->fullUrl(),
            ]);
        }

        $validPlatforms = ['linkedin', 'twitter', 'facebook'];
        if (!in_array($platform, $validPlatforms)) {
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'Invalid platform specified.');
        }

        $driverName = $platform === 'twitter' ? 'twitter-oauth-2' : $platform;
        $driver = \Laravel\Socialite\Facades\Socialite::driver($driverName);

        if ($platform === 'twitter') {
            $driver->setScopes(['tweet.read', 'tweet.write', 'users.read', 'offline.access', 'users.email']);
        }

        // Configure dynamic scopes to match production requirements
        if ($platform === 'linkedin') {
            $driver->setScopes(['openid', 'profile', 'email', 'w_member_social']);
        } elseif ($platform === 'facebook') {
            $driver->setScopes(['public_profile', 'pages_show_list', 'pages_read_engagement', 'pages_manage_posts']);
        }

        return $driver->redirect();
    }

    /**
     * Handle the provider callback and store authorization credentials.
     * NOTE: This route is outside the 'auth' middleware group to prevent
     * silent failures when the session is lost during OAuth redirects.
     */
    public function callback(Request $request, string $platform)
    {
        if (config('app.oauth_debug', false)) {
            \Illuminate\Support\Facades\Log::debug('SocialAccountController::callback hit!', [
                'platform' => $platform,
                'user_id' => Auth::id(),
                'is_authenticated' => Auth::check(),
                'url' => $request->fullUrl(),
                'query_keys' => array_keys($request->all()),
                'has_code' => $request->has('code'),
                'has_state' => $request->has('state'),
                'session_id' => session()->getId(),
                'session_has_state' => session()->has('state'),
                'session_has_code_verifier' => session()->has('code_verifier'),
                'session_state' => session()->get('state'),
                'request_state' => $request->get('state'),
            ]);
        }

        if ($request->has('denied') || $request->get('error') === 'access_denied' || $request->get('error') === 'user_cancelled_login') {
            if (config('app.oauth_debug', false)) {
                \Illuminate\Support\Facades\Log::debug('OAuth user cancellation.', [
                    'platform' => $platform,
                    'user_id' => Auth::id(),
                ]);
            }
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'You cancelled the authorization process.');
        }

        // If user is not authenticated, redirect to login
        if (!Auth::check()) {
            \Illuminate\Support\Facades\Log::warning('OAuth callback: User not authenticated. Session lost during redirect.', [
                'platform' => $platform,
                'session_id' => session()->getId(),
            ]);
            return redirect()->route('login')
                ->with('error', 'Your session expired during the connection process. Please log in and try again.');
        }

        $validPlatforms = ['linkedin', 'twitter', 'facebook'];
        if (!in_array($platform, $validPlatforms)) {
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'Invalid platform specified.');
        }

        $driverName = $platform === 'twitter' ? 'twitter-oauth-2' : $platform;

        try {
            $oauthUser = \Laravel\Socialite\Facades\Socialite::driver($driverName)->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Illuminate\Support\Facades\Log::error('OAuth state mismatch (CSRF protection). Session state lost.', [
                'platform' => $platform,
                'session_state' => session()->get('state'),
                'request_state' => $request->get('state'),
                'session_id' => session()->getId(),
            ]);
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'Connection failed due to a session mismatch. Please try again.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Socialite authentication failed.', [
                'exception' => $e,
                'platform' => $platform,
                'driver' => $driverName,
            ]);
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'Authentication failed. Please try again later.');
        }

        $user = Auth::user();

        // All platforms now use OAuth 2.0 flow
        $accessToken = $oauthUser->token;
        $refreshToken = $oauthUser->refreshToken ?? null;
        $expiresIn = $oauthUser->expiresIn ?? null;
        $expiresAt = $expiresIn ? now()->addSeconds($expiresIn) : null;

        // Try to get nickname, fallback to name, fallback to provider id
        $username = $oauthUser->getNickname() ?: $oauthUser->getName();
        if (!$username) {
            $username = ucfirst($platform) . ' User (' . $oauthUser->getId() . ')';
        }

        // SECURITY FIX AUDIT-1: Duplicate check + write inside a single transaction
        // to close the TOCTOU race condition.
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($user, $platform, $oauthUser, $username, $accessToken, $refreshToken, $expiresAt) {
                // Check for duplicate provider_user_id belonging to another user
                $existingAccount = \App\Models\SocialAccount::where('provider', $platform)
                    ->where('provider_user_id', $oauthUser->getId())
                    ->where('user_id', '!=', $user->id)
                    ->first();

                if ($existingAccount) {
                    \Illuminate\Support\Facades\Log::warning('OAuth conflict: Attempt to connect an already connected social account.', [
                        'platform' => $platform,
                        'provider_user_id' => $oauthUser->getId(),
                        'attempting_user_id' => $user->id,
                        'existing_user_id' => $existingAccount->user_id,
                    ]);
                    throw new \RuntimeException('DUPLICATE_SOCIAL_ACCOUNT');
                }

                $user->socialAccounts()->updateOrCreate(
                    ['provider' => $platform],
                    [
                        'provider_user_id' => $oauthUser->getId(),
                        'username' => $username,
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                        'expires_at' => $expiresAt,
                        'refresh_failures' => 0,
                        'quarantined_until' => null,
                        'scopes' => $oauthUser->approvedScopes ?? implode(',', ['tweet.read', 'tweet.write', 'users.read', 'offline.access']),
                    ]
                );
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'DUPLICATE_SOCIAL_ACCOUNT') {
                return redirect()->route('profile.edit', ['tab' => 'socials'])
                    ->with('error', 'This ' . ucfirst($platform) . ' account is already connected to another user. Please use a different account.');
            }
            throw $e; // Re-throw unexpected RuntimeExceptions
        }

        if (config('app.oauth_debug', false)) {
            \Illuminate\Support\Facades\Log::debug('OAuth connection successful!', [
                'platform' => $platform,
                'username' => $username,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('profile.edit', ['tab' => 'socials'])
            ->with('success', ucfirst($platform) . ' account connected successfully!');
    }

    /**
     * Disconnect/Remove a social account.
     */
    public function disconnect(Request $request, string $platform)
    {
        $user = Auth::user();
        
        $account = $user->socialAccounts()->where('provider', $platform)->first();
        if (!$account) {
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', 'Account not found.');
        }

        // Block disconnect if there are active posts linked to this account
        $activePosts = \App\Models\Post::where('social_account_id', $account->id)
            ->whereIn('status', ['approved', 'publishing', 'paused'])
            ->count();

        if ($activePosts > 0) {
            return redirect()->route('profile.edit', ['tab' => 'socials'])
                ->with('error', "Cannot disconnect: {$activePosts} scheduled post(s) are still pending. Cancel or wait for them to complete first.");
        }

        $account->delete();
        return redirect()->route('profile.edit', ['tab' => 'socials'])
            ->with('success', ucfirst($platform) . ' account disconnected.');
    }
}
