<?php

namespace App\Console\Commands;

use App\Jobs\GenerateCampaignJob;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateTestCampaign extends Command
{
    protected $signature = 'app:generate-test-campaign';
    protected $description = 'Headlessly tests the OpenAI pipeline and auto-cleans.';

    public function handle(): int
    {
        // 1. FATAL PRODUCTION GUARD
        if (app()->environment('production')) {
            $this->error('FATAL: This command is strictly forbidden in production.');
            return Command::FAILURE;
        }

        $user = User::first();
        if (!$user) {
            $this->error('No user found. Register a user first.');
            return Command::FAILURE;
        }

        $this->info('Creating test project...');
        $project = $user->projects()->create(['name' => 'Test Pipeline', 'description' => 'Test']);
        $campaign = $project->campaigns()->create(['status' => 'generating']);

        $this->info('Dispatching OpenAI job synchronously... (This may take up to 2 minutes)');
        
        // 2. SYNCHRONOUS DISPATCH: Blocks CLI until OpenAI finishes and DB is populated
        GenerateCampaignJob::dispatchSync($campaign);

        $postCount = $campaign->posts()->count();
        $this->info("Success! Generated {$postCount} posts.");

        if ($postCount > 0) {
            // 3. AUTO-CLEANUP: Cascades delete to campaigns and posts via SQLite Foreign Keys
            $this->info('Cleaning up test data...');
            $project->delete(); 
            $this->info('Test complete. Database is clean.');
        } else {
            $this->error('Test failed. No posts were generated. Check error_message on campaign.');
        }

        return Command::SUCCESS;
    }
}
