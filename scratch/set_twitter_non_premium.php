<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SocialAccount;

$updated = SocialAccount::where('provider', 'twitter')->update(['is_premium' => false]);
echo "Updated {$updated} Twitter account(s) to is_premium = false.\n";
