<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;

$day1Post = Post::where('day_number', 1)->orderBy('id', 'desc')->first();

if ($day1Post) {
    $newScheduledTime = now()->addMinutes(8);
    $day1Post->update([
        'scheduled_at' => $newScheduledTime,
        'status' => 'approved',
        'error_message' => null,
    ]);

    echo "Day 01 Post #{$day1Post->id} updated successfully!\n";
    echo "New Scheduled Time (UTC): {$day1Post->scheduled_at}\n";
    echo "Current Time (UTC): " . now()->format('Y-m-d H:i:s') . "\n";
    echo "Time remaining: Exactly 8 minutes from now!\n";
} else {
    echo "No Day 1 post found.\n";
}
