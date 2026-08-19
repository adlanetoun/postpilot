<?php

use App\Models\Campaign;
use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$c = Campaign::find(9);
echo 'Campaign #9 Platforms: '.json_encode($c->platforms)."\n";
echo 'Campaign #9 Status: '.$c->status."\n";

// Let's update platforms to ['linkedin', 'twitter', 'facebook'] if empty
if (empty($c->platforms)) {
    $c->platforms = ['linkedin', 'twitter', 'facebook'];
    $c->save();
    echo "Updated Campaign #9 platforms to ['linkedin', 'twitter', 'facebook']\n";
}

// Reset Post #219 status back to 'approved' if it was marked as failed
$post = Post::find(219);
if ($post) {
    $post->status = 'approved';
    $post->scheduled_at = now()->subMinutes(5);
    $post->error_message = null;
    $post->save();
    echo "Reset Post #219 status to 'approved' with scheduled_at = ".$post->scheduled_at."\n";
}
