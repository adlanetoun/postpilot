<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$username = 'adlane_tou75021'; // user's handle from PostPeer payload

// Test 1: Fetch Twitter public page / syndication API
$url = "https://syndication.twitter.com/srv/timeline-profile/screen-name/{$username}";

echo "Fetching Twitter syndication profile for @{$username}...\n";
$response = Http::get($url);

if ($response->successful()) {
    $html = $response->body();
    echo "Syndication response length: " . strlen($html) . " bytes\n";
    if (str_contains($html, 'is_blue_verified') || str_contains($html, 'verified')) {
        echo "Found verification terms in syndication HTML!\n";
    }
} else {
    echo "Syndication request status: " . $response->status() . "\n";
}

// Test 2: Fetch via Twitter public API endpoint / x.com profile
$profileUrl = "https://x.com/{$username}";
$profRes = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($profileUrl);
echo "X.com profile status: " . $profRes->status() . "\n";
