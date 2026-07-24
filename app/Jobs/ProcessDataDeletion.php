<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessDataDeletion implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $provider, public string $providerUserId, public string $confirmationCode)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = \App\Models\DataDeletionRequest::where('confirmation_code', $this->confirmationCode)->first();
        if (!$request) return;

        $request->update(['status' => 'processing']);

        try {
            // Delete associated social accounts
            \App\Models\SocialAccount::where('provider', $this->provider)
                ->where('provider_user_id', $this->providerUserId)
                ->delete();

            // Perform any other anonymization or cascading deletes if necessary

            $request->update(['status' => 'completed']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Data deletion failed', ['exception' => $e]);
            $request->update([
                'status' => 'failed',
                'notes' => $e->getMessage()
            ]);
        }
    }
}
