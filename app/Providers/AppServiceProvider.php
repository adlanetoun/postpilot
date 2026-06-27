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

    }
}
