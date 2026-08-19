<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\SocialAccount;
use Illuminate\Contracts\Console\Kernel;

$deletedCount = SocialAccount::where('provider', 'twitter')->delete();
echo "Cleaned up {$deletedCount} non-premium Twitter social accounts from database.\n";
