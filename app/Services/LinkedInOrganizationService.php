<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInOrganizationService
{
    private const API_BASE = 'https://api.linkedin.com/rest';
    
    // The API version must reflect a supported YYYYMM format to avoid sunset deprecation.
    private const LI_VERSION = '202601'; 

    /**
     * Executes a bipartite fetch to retrieve Organization Names and resolved Logo URLs.
     * 
     * @param string $accessToken The 3-legged OAuth access token.
     * @param array $organizationUrns Array of URNs (e.g. ['urn:li:organization:12345'])
     * @return array Standardized mapping for UI rendering
     */
    public function getOrganizationsForSelection(string $accessToken, array $organizationUrns): array
    {
        if (empty($organizationUrns)) {
            return [];
        }

        // Phase 1: Parse numeric identifiers from the URN strings
        $orgIds = array_map(function ($urn) {
            $parts = explode(':', $urn);
            return end($parts);
        }, $organizationUrns);

        // Construct the strict Rest.li 2.0 protocol headers
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Linkedin-Version' => self::LI_VERSION,
            'X-Restli-Protocol-Version' => '2.0.0',
        ];

        // Construct the unencoded List() syntax for the organizationsLookup endpoint
        $orgListString = implode(',', $orgIds);
        $orgUrl = self::API_BASE . "/organizationsLookup?ids=List({$orgListString})";

        $orgResponse = Http::withHeaders($headers)->get($orgUrl);

        if ($orgResponse->failed()) {
            Log::error('LinkedIn OrganizationsLookup Bipartite Fetch Failed', [
                'status' => $orgResponse->status(),
                'body' => $orgResponse->body()
            ]);
            return [];
        }

        // The response body encapsulates data within the 'results' object
        $orgData = $orgResponse->json('results', []);
        
        $imageUrns = [];
        $organizations = [];

        // Phase 2: Traverse the organization payload to extract image URNs
        foreach ($orgData as $id => $org) {
            $name = $org['localizedName'] ?? 'Unknown Organization';
            
            // Prefer the original image over the cropped variant if available
            $logoV2 = $org['logoV2']['original'] ?? $org['logoV2']['cropped'] ?? null;
            
            $imageUrn = null;
            if ($logoV2) {
                // Mutate legacy digitalmediaAsset formats to compliant image URNs
                $imageUrn = str_replace('digitalmediaAsset', 'image', $logoV2);
                $imageUrns[$id] = $imageUrn; 
            }

            $organizations[$id] = [
                'id' => $id,
                'urn' => "urn:li:organization:{$id}",
                'name' => $name,
                'logo_url' => null, 
                'access_token' => $accessToken // Keep the user's token for LinkedIn
            ];
        }

        // Phase 3: Execute the secondary batch fetch for ephemeral image URLs
        if (!empty($imageUrns)) {
            
            // URL-encode the URN strings to comply with the images API specification
            $encodedUrns = array_map('urlencode', array_values($imageUrns));
            $imageListString = implode(',', $encodedUrns);
            
            $imageUrl = self::API_BASE . "/images?ids=List({$imageListString})";
            $imageResponse = Http::withHeaders($headers)->get($imageUrl);

            if ($imageResponse->successful()) {
                $imageData = $imageResponse->json('results', []);
                
                // Map the resolved ephemeral URLs back to the standardized organization array
                foreach ($imageUrns as $orgId => $urn) {
                    if (isset($imageData[$urn]['downloadUrl'])) {
                        $organizations[$orgId]['logo_url'] = $imageData[$urn]['downloadUrl'];
                    }
                }
            } else {
                Log::warning('LinkedIn Images Resolution Failed', [
                    'body' => $imageResponse->body()
                ]);
            }
        }

        // Re-index the array for seamless iteration within the selection view
        return array_values($organizations);
    }
}
