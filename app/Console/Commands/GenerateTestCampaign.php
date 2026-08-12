<?php

namespace App\Console\Commands;

use App\Jobs\GenerateCampaignJob;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateTestCampaign extends Command
{
    protected $signature = 'app:generate-test-campaign {--force-real-llm : Force using real LLM (only for staging debugging; never in production)}';

    protected $description = 'Headlessly tests the OpenAI pipeline and auto-cleans. Uses mock LLM by default in non-production to avoid consuming real API credits.';

    public function handle(): int
    {
        // 1. FATAL PRODUCTION GUARD
        if (app()->environment('production')) {
            $this->error('FATAL: This command is strictly forbidden in production.');

            return Command::FAILURE;
        }

        // FIX LEAK-1: By default, force the test pipeline to use a stub LLM service.
        // Real LLM calls must be opt-in via --force-real-llm, and even then we
        // refuse in production. This prevents accidental credit consumption
        // on shared staging/CI environments that point at the real Cerebras key.
        $useRealLlm = (bool) $this->option('force-real-llm');
        if (! $useRealLlm) {
            config(['services.cerebras.key' => 'mock_key_for_test_pipeline']);
            config(['services.cerebras.base_url' => 'http://127.0.0.1:1']);
            config(['openai.demo_mode' => true]);
            $this->warn('Using STUB LLM (no real API calls). Pass --force-real-llm to use real Cerebras.');
        } else {
            $this->warn('--force-real-llm set: will hit the real Cerebras API and consume credits.');
        }

        $user = User::first();
        if (! $user) {
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
