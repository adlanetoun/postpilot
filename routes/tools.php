<?php

use App\Http\Controllers\Tools\ToolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Satellite Free Tools Routes (PostPilot Engineering-as-Marketing Engine)
|--------------------------------------------------------------------------
|
| Decoupled, zero-cost, high-converting public micro-tools.
| All tools execute 100% Client-Side with $0 API running costs.
|
*/

Route::prefix('tools')->group(function () {
    // Directory Hub: /tools
    Route::get('/', [ToolController::class, 'index'])->name('tools.index');

    // Individual Tools
    Route::get('/linkedin-post-preview', [ToolController::class, 'linkedinPreview'])->name('tools.linkedin-preview');
    Route::get('/twitter-thread-splitter/{modifier?}', [ToolController::class, 'twitterThreadSplitter'])->name('tools.twitter-thread-splitter');
    Route::get('/linkedin-bold-italic-generator', [ToolController::class, 'linkedinBoldItalic'])->name('tools.linkedin-bold-italic');
    Route::get('/social-character-counter/{modifier?}', [ToolController::class, 'socialCharacterCounter'])->name('tools.social-character-counter');
    Route::get('/social-media-roi-calculator', [ToolController::class, 'socialRoiCalculator'])->name('tools.social-roi-calculator');
    Route::get('/linkedin-line-break-generator', [ToolController::class, 'linkedinLineBreak'])->name('tools.linkedin-line-break');
    Route::get('/utm-link-builder', [ToolController::class, 'utmBuilder'])->name('tools.utm-builder');
    Route::get('/engagement-rate-calculator', [ToolController::class, 'engagementCalculator'])->name('tools.engagement-calculator');
    Route::get('/linkedin-hook-templates', [ToolController::class, 'linkedinHooks'])->name('tools.linkedin-hooks');
    Route::get('/30-day-content-calendar-template', [ToolController::class, 'contentCalendarTemplate'])->name('tools.content-calendar-template');
});

/*
|--------------------------------------------------------------------------
| Embed Routes (Headless Tools for Viral Loops)
|--------------------------------------------------------------------------
*/
Route::prefix('embed')->name('embed.')->group(function () {
    Route::get('/social-character-counter', [ToolController::class, 'socialCharacterCounter'])->name('tools.social-character-counter');
    Route::get('/social-media-roi-calculator', [ToolController::class, 'socialRoiCalculator'])->name('tools.social-roi-calculator');
});
