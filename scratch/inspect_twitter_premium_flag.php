<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\SocialAccount;
use Illuminate\Contracts\Console\Kernel;

$twitterAccounts = SocialAccount::where('provider', 'twitter')->get();

echo "=== TWITTER SOCIAL ACCOUNTS ===\n";
foreach ($twitterAccounts as $acc) {
    echo "ID: {$acc->id} | Username: {$acc->username} | Provider User ID: {$acc->provider_user_id} | is_premium: ".var_export($acc->is_premium, true)."\n";
}
