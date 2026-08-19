<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Post;
use Illuminate\Contracts\Console\Kernel;

echo "=== ALL POSTS MATCHING 'Scene 1' ===\n";
$posts = Post::where('content', 'LIKE', '%Scene 1%')->get();
foreach ($posts as $p) {
    echo "Post #{$p->id} | Day {$p->day_number} | Campaign #{$p->campaign_id} | Status: {$p->status} | ScheduledAt: {$p->scheduled_at} | PublishedAt: {$p->published_at}\n";
    echo 'Content Preview: '.substr($p->content, 0, 100)."...\n\n";
}

echo "=== ALL POSTS FOR CAMPAIGN #15 ===\n";
$c15Posts = Post::where('campaign_id', 15)->orderBy('day_number')->get();
foreach ($c15Posts as $p) {
    echo "Day {$p->day_number} (ID {$p->id}) | Status: {$p->status} | ScheduledAt: {$p->scheduled_at}\n";
    echo 'Content Start: '.substr(str_replace("\n", ' ', $p->content), 0, 80)."\n";
}
