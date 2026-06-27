<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CampaignStatusController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Webhook\DodoWebhookController;
use Illuminate\Support\Facades\Route;

// Operational Core (Dashboard) at the web root protected by auth
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Webhook receiver (Dodo Payments)
Route::post('/webhooks/dodo', [DodoWebhookController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->middleware('throttle:60,1');

// Authenticated user actions
Route::middleware('auth')->group(function () {
    // Projects — campaign generation is expensive, strict throttle (3 per hour in production)
    Route::post('/projects', [ProjectController::class, 'store'])
        ->middleware('throttle:100,1')
        ->name('projects.store');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Posts — moderate throttle (30 edits per minute)
    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->middleware('throttle:30,1')
        ->name('posts.update');

    // Campaign generation status polling endpoint
    Route::get('/campaigns/{campaign}/status', [CampaignStatusController::class, 'show'])->name('campaigns.status');

    // Campaigns Library
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

    // Campaign Approval Action
    Route::post('/campaigns/{campaign}/approve', [CampaignController::class, 'approve'])->name('campaigns.approve');


    // Social Accounts management
    Route::get('/settings/socials/connect/{platform}', [SocialAccountController::class, 'connect'])->name('social-accounts.connect');
    Route::delete('/settings/socials/disconnect/{platform}', [SocialAccountController::class, 'disconnect'])->name('social-accounts.disconnect');

// Unified Account Management / Settings
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// OAuth callback — outside auth middleware to prevent session-loss redirects
// The callback must still have web middleware for session/cookie support (Socialite needs it)
Route::get('/settings/socials/callback/{platform}', [SocialAccountController::class, 'callback'])
    ->name('social-accounts.callback');

// Welcome / landing page for guests
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');



require __DIR__.'/auth.php';

