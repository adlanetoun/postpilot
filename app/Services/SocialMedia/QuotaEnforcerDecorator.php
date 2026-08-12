<?php

namespace App\Services\SocialMedia;

use App\Contracts\SocialMediaPublisherInterface;
use App\DTOs\PostContentDTO;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class QuotaEnforcerDecorator implements SocialMediaPublisherInterface
{
    public function __construct(
        protected SocialMediaPublisherInterface $inner,
        protected int $maxPostsPerMonth = 30
    ) {}

    public function createProfile(string $name): string
    {
        return $this->inner->createProfile($name);
    }

    public function generateConnectUrl(string $providerProfileId, string $platform, ?string $redirectUri = null): string
    {
        return $this->inner->generateConnectUrl($providerProfileId, $platform, $redirectUri);
    }

    public function publishPost(string $providerProfileId, PostContentDTO $post): array
    {
        // Create a unique key for this profile and the current month
        $key = "social_posts_monthly_{$providerProfileId}_".date('Y_m');

        // Check if the limit has been reached
        if (RateLimiter::tooManyAttempts($key, $this->maxPostsPerMonth)) {
            throw new Exception("Monthly posting limit of {$this->maxPostsPerMonth} reached for this profile.");
        }

        // Atomically increment the usage counter (31-day TTL)
        RateLimiter::hit($key, 2678400);

        try {
            // Forward the call to the actual adapter (PostPeer)
            return $this->inner->publishPost($providerProfileId, $post);
        } catch (Exception $e) {
            // FIX D-1: Decrement the counter instead of clearing it entirely.
            // clear() would reset the counter to 0, allowing abuse.
            // We use Cache::decrement() to atomically subtract 1 from the attempts.
            $cacheKey = config('cache.prefix', '').':'.$key;
            Cache::decrement($key);

            throw $e;
        }
    }
}
