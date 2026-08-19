<?php

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$post = Post::find(280);

echo '=== POST 280 PLATFORM PUBLISH AUDIT ==='.PHP_EOL;
echo 'Post ID: '.$post->id.PHP_EOL;
echo 'Status: '.$post->status.PHP_EOL;
echo 'Published At: '.$post->published_at.PHP_EOL;
echo 'Platform Post IDs (Success): '.$post->platform_post_id.PHP_EOL;
echo 'Error Message / Skipped Notes: '.$post->error_message.PHP_EOL;
