<?php

namespace App\Jobs;

use App\Contracts\SocialMediaPublisherInterface;
use App\DTOs\PostContentDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PublishSocialPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * FIX E-1: Retry up to 3 times with exponential backoff (30s, 2min, 5min).
     */
    public int $tries = 3;
    public array $backoff = [30, 120, 300];

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $providerProfileId,
        protected PostContentDTO $postContent
    ) {}

    /**
     * Execute the job.
     */
    public function handle(SocialMediaPublisherInterface $publisher): void
    {
        $publisher->publishPost($this->providerProfileId, $this->postContent);
    }

    /**
     * FIX E-1: Determine if the job should NOT be retried (fatal errors).
     * RuntimeException = auth failure or bad payload → stop retrying immediately.
     * RequestException = 429/5xx → allow retry with backoff.
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Social post publishing failed permanently.', [
            'profileId' => $this->providerProfileId,
            'platforms' => $this->postContent->platforms,
            'error' => $exception->getMessage(),
            'class' => get_class($exception),
        ]);

        // If it's an auth/config error (RuntimeException), don't retry
        if ($exception instanceof RuntimeException) {
            $this->fail($exception);
        }
    }
}
