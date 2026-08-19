<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Http;

$usernames = ['adlane_tou75021', 'elonmusk'];

foreach ($usernames as $u) {
    echo "=== Fetching Twitter GraphQL profile for @{$u} ===\n";
    // Public Nitter / Twitter API proxy or public user details check
    $res = Http::timeout(5)->get("https://nitter.net/{$u}");
    echo 'Nitter response status: '.$res->status()."\n";
    if ($res->successful()) {
        $body = $res->body();
        $isVerified = str_contains($body, 'icon-badge') || str_contains($body, 'icon-verified');
        echo 'Nitter verified badge: '.($isVerified ? 'YES' : 'NO')."\n";
    }
}
