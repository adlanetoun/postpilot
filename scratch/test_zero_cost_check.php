<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$usernames = ['adlane_tou75021', 'elonmusk', 'laravelphp'];

foreach ($usernames as $username) {
    echo "========================================\n";
    echo "Testing 0-Cost Verification Check for @{$username}\n";
    
    // Method 1: Twitter oEmbed API (Public & Free, no auth required)
    $oembedUrl = "https://publish.twitter.com/oembed?url=https://x.com/" . urlencode($username);
    $res1 = Http::get($oembedUrl);
    echo "oEmbed Status: " . $res1->status() . "\n";
    if ($res1->successful()) {
        $json = $res1->json();
        echo "oEmbed Author Name: " . ($json['author_name'] ?? 'N/A') . "\n";
        echo "oEmbed HTML: " . mb_substr($json['html'] ?? '', 0, 150) . "...\n";
    }

    // Method 2: Public User Avatar / Profile Scrape / API v2 public token
    $profileUrl = "https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names=" . urlencode($username);
    $res2 = Http::get($profileUrl);
    echo "Syndication info status: " . $res2->status() . "\n";
    if ($res2->successful()) {
        $data = $res2->json();
        echo "Syndication info: " . json_encode($data) . "\n";
    }
}
