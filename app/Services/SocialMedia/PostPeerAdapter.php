<?php

namespace App\Services\SocialMedia;

use App\Contracts\SocialMediaPublisherInterface;
use App\DTOs\PostContentDTO;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PostPeerAdapter implements SocialMediaPublisherInterface
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        // FIX L-1: Read from the new config/services.php entry
        $this->apiKey = config('services.postpeer.key', '');
        $this->baseUrl = config('services.postpeer.base_url', 'https://api.postpeer.dev/v1');

        if (empty($this->apiKey)) {
            throw new RuntimeException('PostPeer API key is not configured. Set POSTPEER_API_KEY in your .env file.');
        }
    }

    public function createProfile(string $name): string
    {
        $response = Http::timeout(10)->withHeaders([
            'x-access-key' => $this->apiKey,
        ])->post("{$this->baseUrl}/profiles", [
            'name' => $name,
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to create PostPeer profile: '.$response->body());
        }

        $data = $response->json();

        // Log the full response so we can see PostPeer's actual structure
        Log::info('PostPeer createProfile response', ['response' => $data]);

        // Try common key names for the profile ID
        // PostPeer's actual response: { success: true, profile: { id: '...' } }
        $profileId = $data['profile']['id']
            ?? $data['id']
            ?? $data['profileId']
            ?? ($data['data']['id'] ?? null);

        if (empty($profileId)) {
            throw new Exception('PostPeer returned success but no profile ID found in response: '.json_encode($data));
        }

        return (string) $profileId;
    }

    public function generateConnectUrl(string $providerProfileId, string $platform, ?string $redirectUri = null): string
    {
        // NOTE: PostPeer does NOT support redirect after OAuth.
        // It always displays JSON at api.postpeer.dev/v1/connect/{platform}/callback.
        // We handle completion detection via polling (checkStatus endpoint).
        $queryParams = [
            'profileId' => $providerProfileId,
        ];

        $response = Http::timeout(10)->withHeaders([
            'x-access-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/connect/{$platform}", $queryParams);

        if ($response->failed()) {
            throw new Exception("Failed to get PostPeer connect URL for {$platform}: ".$response->body());
        }

        $data = $response->json();
        $url = $data['url'] ?? $data['connectUrl'] ?? null;

        if (empty($url)) {
            throw new Exception('PostPeer returned success but no URL found: '.json_encode($data));
        }

        return $url;
    }

    public function getIntegrations(string $providerProfileId): array
    {
        $response = Http::timeout(5)->withHeaders([
            'x-access-key' => $this->apiKey,
        ])->get("{$this->baseUrl}/connect/integrations", [
            'profileId' => $providerProfileId,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('PostPeer API error: '.$response->status().' — '.$response->body());
        }

        return $response->json('integrations') ?? [];
    }

    public function deleteIntegration(string $integrationId): bool
    {
        $response = Http::withHeaders([
            'x-access-key' => $this->apiKey,
        ])->delete("{$this->baseUrl}/connect/integrations/{$integrationId}");

        return $response->successful();
    }

    public function publishPost(string $providerProfileId, PostContentDTO $post): array
    {
        $payload = [
            'content' => $post->content,
            'platforms' => $post->platforms,
        ];

        if ($post->mediaUrl) {
            $payload['media'] = [$post->mediaUrl];
        }

        $response = Http::timeout(30)->withHeaders([
            'x-access-key' => $this->apiKey,
        ])->post("{$this->baseUrl}/posts", $payload);

        // FIX E-2: Distinguish between retryable and fatal HTTP errors
        if ($response->failed()) {
            $status = $response->status();
            $body = $response->body();

            // 401/403: Auth failure — do NOT retry, the API key is wrong or revoked
            if (in_array($status, [401, 403])) {
                throw new RuntimeException("[PostPeer Auth Error {$status}] API key invalid or revoked. Body: {$body}");
            }

            // 429: Rate limited by PostPeer — safe to retry after backoff
            if ($status === 429) {
                throw new RequestException($response->toPsrResponse());
            }

            // 5xx: Server error — safe to retry
            if ($status >= 500) {
                throw new RequestException($response->toPsrResponse());
            }

            // 4xx: Client error (bad payload, validation) — do NOT retry
            throw new RuntimeException("[PostPeer Client Error {$status}] {$body}");
        }

        return $response->json();
    }
}
