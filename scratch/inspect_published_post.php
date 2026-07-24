<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;

$recentPublished = Post::where('status', 'published')
    ->orderBy('published_at', 'desc')
    ->first();

if ($recentPublished) {
    echo "=== RECENTLY PUBLISHED POST ===\n";
    echo "ID: {$recentPublished->id}\n";
    echo "Day: {$recentPublished->day_number}\n";
    echo "Campaign ID: {$recentPublished->campaign_id}\n";
    echo "Is Demo: " . ($recentPublished->is_demo ? 'YES (Stub)' : 'NO (Real)') . "\n";
    echo "Published At: {$recentPublished->published_at}\n";
    echo "Content:\n{$recentPublished->content}\n";
    echo "Platform Post IDs: {$recentPublished->platform_post_id}\n";
    echo "Error Messages: {$recentPublished->error_message}\n";
} else {
    echo "No published posts found.\n";
}

echo "\n=== ALL CAMPAIGNS FOR THIS PROJECT ===\n";
$campaigns = \App\Models\Campaign::with('posts')->orderBy('id', 'desc')->get();
foreach ($campaigns as $c) {
    echo "Campaign #{$c->id} | Status: {$c->status} | Is Demo: " . ($c->is_demo ? 'YES' : 'NO') . " | Post Count: " . $c->posts->count() . "\n";
}
