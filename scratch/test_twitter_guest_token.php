<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

// Test fetching Twitter Guest Token (Public & Free)
echo "Fetching Twitter Public Guest Token...\n";
$tokenRes = Http::withHeaders([
    'Authorization' => 'Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA'
])->post('https://api.twitter.com/1.1/guest/activate.json');

echo "Guest Token Response Status: " . $tokenRes->status() . "\n";

if ($tokenRes->successful()) {
    $guestToken = $tokenRes->json('guest_token');
    echo "Guest Token: " . $guestToken . "\n";

    $usernames = ['adlane_tou75021', 'elonmusk'];
    foreach ($usernames as $u) {
        echo "=== Querying User: {$u} ===\n";
        $userRes = Http::withHeaders([
            'Authorization' => 'Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA',
            'x-guest-token' => $guestToken,
        ])->get("https://api.twitter.com/1.1/users/show.json?screen_name={$u}");

        echo "User status: " . $userRes->status() . "\n";
        if ($userRes->successful()) {
            $data = $userRes->json();
            echo "Name: " . ($data['name'] ?? 'N/A') . "\n";
            echo "Verified: " . (isset($data['verified']) ? ($data['verified'] ? 'YES' : 'NO') : 'N/A') . "\n";
            echo "Verified Type: " . ($data['verified_type'] ?? 'N/A') . "\n";
            echo "Ext Verified Type: " . ($data['ext_verified_type'] ?? 'N/A') . "\n";
            echo "Is Blue Verified: " . (isset($data['is_blue_verified']) ? ($data['is_blue_verified'] ? 'YES' : 'NO') : 'N/A') . "\n";
        } else {
            echo "User Error: " . $userRes->body() . "\n";
        }
    }
}
