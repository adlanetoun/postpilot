<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\SocialMedia\PostPeerAdapter;
use App\DTOs\PostContentDTO;

$adapter = app(PostPeerAdapter::class);
$postpeerProfileId = '6a60ce08516e209286aa9de0';
$integrationId = '6a620f54d25dbd6e20788384';

// Create a 300-character test string
$longTestText = str_repeat('X Premium Verification Test. ', 11); // ~319 chars

echo "Testing 300-character post payload to Twitter integration ID {$integrationId}...\n";

$dto = new PostContentDTO(
    content: $longTestText,
    platforms: [['platform' => 'twitter', 'accountId' => $integrationId]]
);

try {
    $res = $adapter->publishPost($postpeerProfileId, $dto);
    echo "SUCCESS: " . json_encode($res) . "\n";
} catch (\Exception $e) {
    echo "CAUGHT EXCEPTION: " . $e->getMessage() . "\n";
    if (str_contains($e->getMessage(), 'exceeds X\'s 280-character limit')) {
        echo "--> EMPIRICAL PROOF: ACCOUNT IS NOT PREMIUM (FREE 280-CHAR LIMIT ENFORCED BY X!)\n";
    }
}
