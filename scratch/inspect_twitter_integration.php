<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\SocialAccount;
use App\Services\SocialMedia\PostPeerAdapter;
use Illuminate\Contracts\Console\Kernel;

$postpeerAccount = SocialAccount::where('provider', 'postpeer')->first();

if (! $postpeerAccount) {
    echo "No PostPeer account found.\n";
    exit;
}

$adapter = app(PostPeerAdapter::class);

try {
    $integrations = $adapter->getIntegrations($postpeerAccount->provider_user_id);
    echo "=== POSTPEER INTEGRATIONS JSON payload ===\n";
    echo json_encode($integrations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n";
} catch (Exception $e) {
    echo 'Error fetching integrations: '.$e->getMessage()."\n";
}
