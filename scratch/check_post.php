<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$post = Post::with('socialAccount', 'campaign.project.socialAccounts')->find(219);
echo "Post #219 details:\n";
echo 'Status: '.$post->status."\n";
echo 'Error Message: '.($post->error_message ?? 'None')."\n";
echo 'Social Account ID: '.($post->social_account_id ?? 'NULL')."\n";
echo 'Platforms array/json: '.json_encode($post->campaign->platforms)."\n";
echo "Project Social Accounts:\n";
foreach ($post->campaign->project->socialAccounts as $sa) {
    echo " - Provider: {$sa->provider}, Provider User ID: {$sa->provider_user_id}, Username: {$sa->username}\n";
}
