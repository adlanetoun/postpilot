<?php

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$now = Carbon::now();
$targetTime = $now->copy()->addMinutes(2); // 2-3 minutes from now

$post = Post::find(281); // Day 3 post
if ($post) {
    $post->scheduled_at = $targetTime;
    $post->status = 'approved';
    $post->save();
    echo 'SUCCESS: Day 3 Post (ID: 281) status set to approved and scheduled_at updated to '.$post->scheduled_at->toDateTimeString().' (Current time: '.$now->toDateTimeString().')'.PHP_EOL;
} else {
    echo 'Post 281 not found.'.PHP_EOL;
}
