<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\SocialAccount;
use Illuminate\Contracts\Console\Kernel;

$updated = SocialAccount::where('provider', 'twitter')->update(['is_premium' => false]);
echo "Updated {$updated} Twitter account(s) to is_premium = false.\n";
