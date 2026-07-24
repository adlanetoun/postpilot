<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$keys = config('services.cerebras.keys', []);
echo "Testing " . count($keys) . " keys...\n\n";

foreach ($keys as $index => $key) {
    $masked = substr($key, 0, 10) . '...';
    
    $response = Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $key,
        'Content-Type' => 'application/json',
    ])->post('https://api.cerebras.ai/v1/chat/completions', [
        'model' => 'gpt-oss-120b',
        'messages' => [
            ['role' => 'user', 'content' => 'Hi']
        ],
        'max_tokens' => 5,
    ]);

    $status = $response->status();
    echo "Key $index ($masked): HTTP $status";
    
    if ($status === 401) {
        echo " ❌ (UNAUTHORIZED - THIS KEY IS BROKEN!)";
    } elseif ($status === 429) {
        echo " ⚠️ (Rate Limited)";
    } elseif ($status === 200) {
        echo " ✅ (Works)";
    } else {
        echo " ❓ (Unknown error)";
    }
    echo "\n";
}
