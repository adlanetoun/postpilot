<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Post;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Throwable;

class GenerateCampaignJob implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // SECURITY FIX 6-A: Explicit timeout and tries to prevent indefinite hangs
    public $tries = 2;
    public $timeout = 300; // 5 minutes max to set up the batch

    public $campaignId;
    protected $totalDays = 30;
    protected $platforms = ['linkedin', 'twitter', 'facebook'];

    public function __construct($campaignId) 
    {
        // Accept either a Campaign model or an ID
        $this->campaignId = $campaignId instanceof Campaign ? $campaignId->id : $campaignId;
    }

    public function handle(OpenAIService $openAiService): void 
    {
        $campaign = Campaign::with('project.user')->findOrFail($this->campaignId);
        
        if (!empty($campaign->platforms)) {
            $platforms = $campaign->platforms;
            if (is_string($platforms)) {
                $platforms = json_decode($platforms, true) ?? [];
            }
            if (is_array($platforms) && !empty($platforms)) {
                $this->platforms = array_values($platforms);
            }
        }

        if (!is_array($this->platforms)) {
            $this->platforms = ['linkedin', 'twitter', 'facebook'];
        }

        $timezone = $campaign->project->user->timezone ?? 'UTC';
        $chunks = $this->calculateWeeklyChunks();

        // REVENUE LEAK-3: Initialize expected_post_count to the total planned
        // posts so chunk-failure handlers can decrement it for forensic
        // under-delivery measurement (credit charged at approve() time vs.
        // posts actually generated).
        $totalExpected = 0;
        $platformCount = is_array($this->platforms) ? count($this->platforms) : 1;
        foreach ($chunks as $chunk) {
            $totalExpected += ($chunk['end_day'] - $chunk['start_day'] + 1) * $platformCount;
        }
        $campaign->update(['expected_post_count' => $totalExpected]);

        $jobs = [];
        foreach ($chunks as $index => $chunk) {
            $jobs[] = new GenerateCampaignChunkJob(
                $this->campaignId,
                $index + 1,
                count($chunks),
                $chunk['start_day'],
                $chunk['end_day'],
                $this->platforms,
                $timezone
            );
        }

        $campaignId = $this->campaignId;
        $batch = \Illuminate\Support\Facades\Bus::batch($jobs)->then(function (\Illuminate\Bus\Batch $batch) use ($campaignId) {
            Campaign::where('id', $campaignId)->update(['status' => 'completed']);
        })->catch(function (\Illuminate\Bus\Batch $batch, \Throwable $e) use ($campaignId) {
            $campaign = Campaign::with('project.user')->find($campaignId);
            // SECURITY FIX: Check status before rolling back to prevent double refunds
            if ($campaign && $campaign->status !== 'failed_generation') {
                $campaign->update([
                    'status' => 'failed_generation',
                    'error_message' => 'A chunk failed: ' . \Illuminate\Support\Str::limit($e->getMessage(), 250)
                ]);
            }
        });

        // Add 10 seconds delay between each chunk job to prevent API rate limiting (HTTP 429)
        foreach ($jobs as $index => $job) {
            $job->delay(now()->addSeconds($index * 10));
        }

        $batch->dispatch();
    }

    private function calculateWeeklyChunks(): array
    {
        $chunks = [];
        $currentDay = 1;

        while ($currentDay <= $this->totalDays) {
            $endDay = min($currentDay + 6, $this->totalDays); // 7 days per chunk
            
            $platformCount = is_array($this->platforms) ? count($this->platforms) : 1;
            $chunks[] = [
                'start_day' => $currentDay,
                'end_day' => $endDay,
                'post_count' => ($endDay - $currentDay + 1) * $platformCount // Max 28 posts
            ];
            
            $currentDay = $endDay + 1;
        }

        return $chunks;
    }

    public function failed(Throwable $exception): void
    {
        $campaign = Campaign::with('project.user')->find($this->campaignId);
        // SECURITY FIX: Check status before rolling back to prevent double refunds
        if ($campaign && $campaign->status !== 'failed_generation') {
            $campaign->update([
                'status' => 'failed_generation',
                'error_message' => Str::limit($exception->getMessage(), 250),
            ]);
        }
    }
}
