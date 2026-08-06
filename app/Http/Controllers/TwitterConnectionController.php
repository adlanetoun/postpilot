<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class TwitterConnectionController extends Controller
{
    /**
     * Redirect the user to the Twitter OAuth 2.0 consent screen.
     */
    public function redirect(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Verify signed URL to prevent CSRF
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        // Store the project ID so we know which project to attach the account to
        session()->put('twitter_oauth_project_id', $project->id);

        return Socialite::driver('twitter')
            ->setScopes(['tweet.read', 'tweet.write', 'users.read', 'offline.access'])
            ->redirect();
    }

    /**
     * Handle the callback from Twitter after authentication.
     */
    public function callback(Request $request)
    {
        $projectId = session()->pull('twitter_oauth_project_id');

        if (! $projectId) {
            return view('socials.popup-callback', [
                'status' => 'error',
                'message' => 'Session expired or invalid request. Please try connecting again.',
                'platform' => 'twitter',
            ]);
        }

        try {
            $project = Project::findOrFail($projectId);

            if ($project->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            // Retrieve the user from Socialite using the OAuth 2.0 flow
            $twitterUser = Socialite::driver('twitter')->user();

            // Check if this Twitter account is already attached to a DIFFERENT project
            $alreadyUsedByOther = SocialAccount::where('provider', 'twitter')
                ->where('provider_user_id', $twitterUser->getId())
                ->where('project_id', '!=', $project->id)
                ->exists();

            if ($alreadyUsedByOther) {
                return view('socials.popup-callback', [
                    'status' => 'error',
                    'message' => 'This X (Twitter) account is already connected to another project.',
                    'platform' => 'twitter',
                ]);
            }

            // Calculate expiration time from expiresIn
            $expiresAt = $twitterUser->expiresIn ? now()->addSeconds($twitterUser->expiresIn) : now()->addHours(2);

            // Save or update the connection in the database
            $project->socialAccounts()->updateOrCreate(
                ['provider' => 'twitter'],
                [
                    'user_id' => Auth::id(),
                    'provider_user_id' => $twitterUser->getId(),
                    'username' => $twitterUser->getNickname() ?? $twitterUser->getName(),
                    'access_token' => $twitterUser->token,
                    'refresh_token' => $twitterUser->refreshToken,
                    'expires_at' => $expiresAt,
                    'scopes' => 'tweet.read,tweet.write,users.read,offline.access',
                    'refresh_failures' => 0,
                    'quarantined_until' => null,
                ]
            );

            // Output the bridge popup callback view to seamlessly close and refresh
            return view('socials.popup-callback', [
                'status' => 'success',
                'message' => 'X (Twitter) connected successfully.',
                'platform' => 'twitter',
            ]);

        } catch (\Exception $e) {
            Log::error('Twitter OAuth callback failed: '.$e->getMessage());

            return view('socials.popup-callback', [
                'status' => 'error',
                'message' => 'Failed to connect to X (Twitter). Please try again.',
                'platform' => 'twitter',
            ]);
        }
    }
}
