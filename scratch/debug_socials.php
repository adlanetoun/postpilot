<?php

use App\Models\Campaign;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$c = Campaign::find(9);
echo 'PROJECT ID: '.$c->project_id."\n";
echo 'Campaign Platforms: '.json_encode($c->platforms)."\n";
foreach ($c->project->socialAccounts as $sa) {
    echo "ID: {$sa->id} | Provider: {$sa->provider} | Username: '{$sa->username}' | ProviderUserID: '{$sa->provider_user_id}'\n";
}
