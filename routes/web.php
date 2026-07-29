<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CampaignStatusController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\ProfileController;
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

Route::get('/refunds', function () {
    return view('legal.refunds');
})->name('legal.refunds');

// Operational Core (Dashboard) at the web root protected by auth
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Webhook receivers
Route::post('/webhooks/dodo', [DodoWebhookController::class, 'handle'])
    ->middleware('throttle:60,1');
Route::post('/webhooks/paddle', PaddleWebhookController::class)
    ->middleware('throttle:60,1');

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
    Route::get('/projects/{project}/socials/connect/{platform}', [\App\Http\Controllers\SocialConnectionController::class, 'connect'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.connect');
    Route::get('/projects/{project}/socials/connect-popup/{platform}', [\App\Http\Controllers\SocialConnectionController::class, 'connectPopup'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.connect-popup');
    Route::delete('/projects/{project}/socials/disconnect/{platform}', [\App\Http\Controllers\SocialConnectionController::class, 'disconnect'])
        ->middleware('throttle:20,1')
        ->name('social-accounts.disconnect');
    
    // Polling endpoint to check connection status
    Route::get('/projects/{project}/socials/check-status', [\App\Http\Controllers\SocialConnectionController::class, 'checkStatus'])
        ->middleware('throttle:60,1')
        ->name('social-accounts.check-status');
        
    // Route to force-close popups cross-origin
    Route::get('/social-accounts/close-popup', function() {
        return "<script>window.close();</script>";
    })->name('social-accounts.close-popup');

    // Page selection flow (after PostPeer OAuth)
    Route::get('/projects/{project}/socials/{platform}/select-page', [\App\Http\Controllers\SocialConnectionController::class, 'selectPage'])
        ->name('social-accounts.select-page');
    Route::post('/projects/{project}/socials/{platform}/save-page', [\App\Http\Controllers\SocialConnectionController::class, 'savePage'])
        ->name('social-accounts.save-page');

// Unified Account Management / Settings
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRO: Annual Plan Waitlist Capture
    Route::post('/waitlist/annual', [WaitlistController::class, 'store'])->name('waitlist.annual');

    // Real-time credits polling endpoint after checkout
    Route::get('/api/user/credits', function () {
        return response()->json([
            'credits' => (int) (auth()->user() ? auth()->user()->fresh()->campaign_credits : 0)
        ]);
    })->name('api.user.credits');
});

// Facebook Data Deletion
Route::post('/settings/socials/facebook/data-deletion', [\App\Http\Controllers\FacebookDataDeletionController::class, 'handle'])
    ->name('socials.facebook.data-deletion');
Route::get('/settings/socials/facebook/data-deletion-status/{code}', [\App\Http\Controllers\FacebookDataDeletionController::class, 'status'])
    ->name('socials.facebook.data-deletion-status');

require __DIR__.'/auth.php';



