<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\SocialMedia\PostPeerAdapter;
use App\DTOs\PostContentDTO;

$postpeerProfileId = '6a60ce08516e209286aa9de0';
$integrationId = '6a620f54d25dbd6e20788384';
$username = '@adlane_tou75021';

$adapter = app(PostPeerAdapter::class);

echo "Simulating savePage X Premium verification probe for {$username} (Integration: {$integrationId})...\n";

$isPremium = false;
$testPayload = str_repeat('X Premium Verification Test. ', 11); // 319 chars

try {
    $dto = new PostContentDTO(
        content: $testPayload,
        platforms: [['platform' => 'twitter', 'accountId' => $integrationId]]
    );
    $res = $adapter->publishPost($postpeerProfileId, $dto);
    $isPremium = true;
    echo "Account is Premium! Test post result: " . json_encode($res) . "\n";
} catch (\Exception $e) {
    if (str_contains($e->getMessage(), 'exceeds X\'s 280-character limit')) {
        echo "CATCH: Account is NOT Premium (280 char limit error detected!)\n";
        $isPremium = false;
    } else {
        echo "CATCH: Other error: " . $e->getMessage() . "\n";
    }
}

if (!$isPremium) {
    echo "REJECTING CONNECTION: Deleting integration {$integrationId} from PostPeer...\n";
    $deleted = $adapter->deleteIntegration($integrationId);
    echo "Integration deleted from PostPeer: " . ($deleted ? 'YES' : 'NO') . "\n";
    echo "USER ERROR MESSAGE: X (Twitter) Premium Required: Your account {$username} does not have X Premium / Blue verification. Automated 30-day AI campaign publishing requires an X Premium account.\n";
}
