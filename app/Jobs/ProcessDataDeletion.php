<?php

namespace App\Jobs;

use App\Models\DataDeletionRequest;
use App\Models\SocialAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessDataDeletion implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $provider, public string $providerUserId, public string $confirmationCode) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = DataDeletionRequest::where('confirmation_code', $this->confirmationCode)->first();
        if (! $request) {
            return;
        }

        $request->update(['status' => 'processing']);

        try {
            // Delete associated social accounts
            SocialAccount::where('provider', $this->provider)
                ->where('provider_user_id', $this->providerUserId)
                ->delete();

            // Perform any other anonymization or cascading deletes if necessary

            $request->update(['status' => 'completed']);
        } catch (\Exception $e) {
            Log::error('Data deletion failed', ['exception' => $e]);
            $request->update([
                'status' => 'failed',
                'notes' => $e->getMessage(),
            ]);
        }
    }
}
