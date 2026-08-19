<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

// Get latest post or Day 1 post
$post = Post::orderBy('id', 'desc')->first();

if (! $post) {
    echo "No posts found in database.\n";
    exit;
}

$newScheduledTime = now()->addMinutes(8);

$post->update([
    'scheduled_at' => $newScheduledTime,
    'status' => 'approved',
    'error_message' => null,
]);

echo "Post #{$post->id} (Day {$post->day_number}) updated successfully!\n";
echo "New Scheduled Time (UTC): {$post->scheduled_at}\n";
echo 'Current Time (UTC): '.now()->format('Y-m-d H:i:s')."\n";
echo 'Diff in Minutes: '.round(now()->diffInMinutes($post->scheduled_at, false), 1)." mins from now\n";
