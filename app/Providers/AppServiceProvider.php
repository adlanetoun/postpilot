<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['session.driver' => 'file']);

        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Apply SQLite PRAGMAs to BOTH main and queue connections safely for Railway volume
        foreach (['sqlite', 'sqlite_queue'] as $connection) {
            try {
                if (DB::connection($connection)->getDriverName() === 'sqlite') {
                    DB::connection($connection)->statement('PRAGMA journal_mode=DELETE;');
                    DB::connection($connection)->statement('PRAGMA busy_timeout=5000;');
                    DB::connection($connection)->statement('PRAGMA foreign_keys=ON;');
                    DB::connection($connection)->statement('PRAGMA synchronous=NORMAL;');
                    DB::connection($connection)->statement('PRAGMA cache_size = -20000;');
                }
            } catch (\Exception $e) {
                // Queue DB may not exist yet during initial migrations
                Log::warning("Could not apply PRAGMAs to {$connection}: ".$e->getMessage());
            }
        }

        // FREE-TIER ROUTING: Demo mode is now decided per-request by the chunk job
        // based on the user's remaining credits, not globally. The job resolves
        // StubOpenAIService directly when the user has no credits left, and
        // posts are tagged with is_demo=true to block publishing.
        //
        // The openai.demo_mode config still works for landing-page preview CTAs
        // and PHPUnit tests where no user context exists.
    }
}
