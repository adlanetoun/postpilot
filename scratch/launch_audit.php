<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$jobs = \Illuminate\Support\Facades\DB::table('failed_jobs')->get();
echo "FAILED JOBS DETAILED INSPECTION:" . PHP_EOL;
foreach ($jobs as $j) {
    echo "ID: {$j->id} | Queue: {$j->queue} | Failed At: {$j->failed_at}" . PHP_EOL;
    echo "Exception: " . substr($j->exception, 0, 150) . "..." . PHP_EOL;
    echo "---------------------------------------------------" . PHP_EOL;
}
