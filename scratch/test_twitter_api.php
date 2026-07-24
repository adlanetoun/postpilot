<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$usernames = ['adlane_tou75021', 'elonmusk'];

foreach ($usernames as $u) {
    echo "=== Testing User: {$u} ===\n";
    // Check Twitter GraphQL / public CDN endpoints
    $res = Http::withHeaders([
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
    ])->get("https://x.com/{$u}");

    $body = $res->body();
    $isBlue = str_contains($body, '"is_blue_verified":true') || str_contains($body, '"verified":true');
    echo "Contains blue/verified true: " . ($isBlue ? 'YES' : 'NO') . "\n";
    
    // Check if we can find verified_type or is_blue_verified in json script tags
    preg_match_all('/"is_blue_verified"\s*:\s*(true|false)/i', $body, $matches);
    echo "is_blue_verified matches: " . json_encode($matches[0] ?? []) . "\n\n";
}
