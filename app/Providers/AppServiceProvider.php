<?php

namespace App\Providers;

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
if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || str_contains(config('app.url'), 'https://')) {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

        // SECURITY FIX 5-A: Apply SQLite PRAGMAs to BOTH main and queue connections
        foreach (['sqlite', 'sqlite_queue'] as $connection) {
            try {
                if (\Illuminate\Support\Facades\DB::connection($connection)->getDriverName() === 'sqlite') {
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA journal_mode=WAL;');
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA busy_timeout=5000;');
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA foreign_keys=ON;');
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA synchronous=NORMAL;');
                    
                    // CRITICAL FIX: Force checkpoint every 100 pages (default is 1000)
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA wal_autocheckpoint = 100;');
                    
                    // Increase cache size to 20MB to reduce disk I/O on Fly.io NVMe
                    \Illuminate\Support\Facades\DB::connection($connection)->statement('PRAGMA cache_size = -20000;');
                }
            } catch (\Exception $e) {
                // Queue DB may not exist yet during initial migrations
                \Illuminate\Support\Facades\Log::warning("Could not apply PRAGMAs to {$connection}: " . $e->getMessage());
            }
        }

        // Override the default Socialite twitter-oauth-2 provider with our custom one
        \Laravel\Socialite\Facades\Socialite::extend('twitter-oauth-2', function ($app) {
            $config = $app['config']['services.twitter-oauth-2'];
            return \Laravel\Socialite\Facades\Socialite::buildProvider(\App\Providers\CustomTwitterProvider::class, $config);
        });

        // FREE-TIER ROUTING: Demo mode is now decided per-request by the chunk job
        // based on the user's remaining credits, not globally. The job resolves
        // StubOpenAIService directly when the user has no credits left, and
        // posts are tagged with is_demo=true to block publishing.
        //
        // The openai.demo_mode config still works for landing-page preview CTAs
        // and PHPUnit tests where no user context exists.
    }
}
