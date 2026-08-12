<?php

namespace App\Providers;

use App\Contracts\SocialMediaPublisherInterface;
use App\Services\SocialMedia\PostPeerAdapter;
use App\Services\SocialMedia\QuotaEnforcerDecorator;
use Illuminate\Support\ServiceProvider;

class SocialMediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SocialMediaPublisherInterface::class, function ($app) {
            // 1. Instantiate the base adapter
            $baseAdapter = new PostPeerAdapter;

            // 2. Wrap it with the Quota Decorator (limit to 30 posts)
            return new QuotaEnforcerDecorator($baseAdapter, 30);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
