<?php

namespace App\Contracts;

use App\DTOs\PostContentDTO;

interface SocialMediaPublisherInterface
{
    /**
     * Create a new isolated profile for a tenant.
     *
     * @return string The provider's unique profile ID
     */
    public function createProfile(string $name): string;

    /**
     * Generate an OAuth connection URL for a specific profile and platform.
     *
     * @param  string  $platform  (e.g., 'facebook', 'linkedin')
     * @return string The URL to redirect the user to
     */
    public function generateConnectUrl(string $providerProfileId, string $platform, ?string $redirectUri = null): string;

    /**
     * Publish a post via the social media provider.
     *
     * @return array Response from the provider
     */
    public function publishPost(string $providerProfileId, PostContentDTO $post): array;
}
