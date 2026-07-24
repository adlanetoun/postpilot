<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$post = App\Models\Post::find(219);
if ($post) {
    $post->scheduled_at = now()->subMinutes(5);
    $post->save();
    echo "SUCCESS: Post #219 scheduled_at updated to " . $post->scheduled_at . "\n";
} else {
    echo "ERROR: Post #219 not found\n";
}
