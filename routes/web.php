<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignStatusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacebookDataDeletionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialConnectionController;
use App\Http\Controllers\TwitterConnectionController;
use App\Http\Controllers\WaitlistController;
use App\Http\Controllers\Webhook\DodoWebhookController;
use App\Http\Controllers\Webhook\PaddleWebhookController;
use Illuminate\Support\Facades\Route;

// Public Legal Pages (Paddle & Compliance Verification)
Route::get('/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/legal/refunds', function () {
    return view('legal.refunds');
})->name('legal.refunds');

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dynamic XML Sitemap for SEO & Search Console
Route::get('/sitemap.xml', function () {
    $urls = [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => route('tools.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => route('tools.linkedin-preview'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.twitter-thread-splitter'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.linkedin-bold-italic'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.social-character-counter'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.social-roi-calculator'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.linkedin-line-break'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.utm-builder'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.engagement-calculator'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.linkedin-hooks'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('tools.content-calendar-template'), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['url' => route('legal.terms'), 'priority' => '0.3', 'changefreq' => 'monthly'],
        ['url' => route('legal.privacy'), 'priority' => '0.3', 'changefreq' => 'monthly'],
        ['url' => route('legal.refunds'), 'priority' => '0.3', 'changefreq' => 'monthly'],
    ];

    $modifiers = config('tool_modifiers', []);
    foreach ($modifiers as $tool => $mods) {
        foreach ($mods as $modSlug => $data) {
            $urls[] = [
                'url' => url("/tools/{$tool}/{$modSlug}"),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $item) {
        $xml .= '<url>';
        $xml .= '<loc>' . htmlspecialchars($item['url']) . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $xml .= '<changefreq>' . $item['changefreq'] . '</changefreq>';
        $xml .= '<priority>' . $item['priority'] . '</priority>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'text/xml');
})->name('sitemap');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('/home', '/dashboard');

// Webhook receivers
Route::post('/webhooks/dodo', [DodoWebhookController::class, 'handle'])
    ->middleware('throttle:60,1');
Route::post('/webhooks/paddle', PaddleWebhookController::class)
    ->middleware(['throttle:60,1']);

// Authenticated user actions
Route::middleware('auth')->group(function () {
    // Projects
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Campaigns (Creation & Library)
    Route::post('/projects/{project}/campaigns', [CampaignController::class, 'store'])
        ->middleware(['throttle:10,1', 'has_campaign_credits'])
        ->name('campaigns.store');
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    // Posts — moderate throttle (30 edits per minute)
    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->middleware('throttle:30,1')
        ->name('posts.update');

    // Campaign generation status polling endpoint
    Route::get('/campaigns/{campaign}/status', [CampaignStatusController::class, 'show'])->name('campaigns.status');

    // Campaign Approval Action
    Route::post('/campaigns/{campaign}/approve', [CampaignController::class, 'approve'])
        ->name('campaigns.approve');
    Route::post('/campaigns/{campaign}/revoke-approval', [CampaignController::class, 'revokeApproval'])->name('campaigns.revokeApproval');
    Route::post('/campaigns/{campaign}/toggle-pause', [CampaignController::class, 'togglePause'])->name('campaigns.togglePause');

    // Social Accounts management (Project-Level) — via PostPeer
    Route::get('/projects/{project}/socials/connect/{platform}', [SocialConnectionController::class, 'connect'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.connect');
    Route::get('/projects/{project}/socials/connect-popup/{platform}', [SocialConnectionController::class, 'connectPopup'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.connect-popup');
    Route::delete('/projects/{project}/socials/disconnect/{platform}', [SocialConnectionController::class, 'disconnect'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.disconnect');

    // Direct Twitter API Connection routes
    Route::get('/projects/{project}/socials/connect-direct/twitter', [TwitterConnectionController::class, 'redirect'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.connect-twitter');

    // Polling endpoint to check connection status
    Route::get('/projects/{project}/socials/check-status', [SocialConnectionController::class, 'checkStatus'])
        ->middleware('throttle:60,1')
        ->name('social-accounts.check-status');

    // Route to force-close popups cross-origin
    Route::get('/social-accounts/close-popup', function () {
        return '<script>window.close();</script>';
    })->name('social-accounts.close-popup');

    // Page selection flow (after PostPeer OAuth)
    Route::get('/projects/{project}/socials/{platform}/select-page', [SocialConnectionController::class, 'selectPage'])
        ->name('social-accounts.select-page');
    Route::post('/projects/{project}/socials/{platform}/save-page', [SocialConnectionController::class, 'savePage'])
        ->name('social-accounts.save-page');

    // Unified Account Management / Settings
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Twitter OAuth 2.0 Callback
    Route::get('/settings/socials/callback/twitter', [TwitterConnectionController::class, 'callback'])
        ->name('socials.twitter.callback');

    // CRO: Annual Plan Waitlist Capture
    Route::post('/waitlist/annual', [WaitlistController::class, 'store'])->name('waitlist.annual');

    // Real-time credits polling endpoint after checkout
    Route::get('/api/user/credits', function () {
        return response()->json([
            'credits' => (int) (auth()->user() ? auth()->user()->fresh()->campaign_credits : 0),
        ]);
    })->name('api.user.credits');
});

// Facebook Data Deletion
Route::post('/settings/socials/facebook/data-deletion', [FacebookDataDeletionController::class, 'handle'])
    ->name('socials.facebook.data-deletion');
Route::get('/settings/socials/facebook/data-deletion-status/{code}', [FacebookDataDeletionController::class, 'status'])
    ->name('socials.facebook.data-deletion-status');

require __DIR__.'/auth.php';
require __DIR__.'/tools.php';
