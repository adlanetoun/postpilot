<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\OpenAIService;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Batchable;

class GenerateCampaignChunkJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 4;
    public $timeout = 120;

    public function backoff(): array
    {
        // Exponential backoff: 10s, 60s, 5 mins, 15 mins.
        return [10, 60, 300, 900];
    }

    public function __construct(
        protected int $campaignId,
        protected int $chunkNumber,
        protected int $totalChunks,
        protected int $startDay,
        protected int $endDay,
        protected array $platforms,
        protected string $timezone = 'UTC'
    ) {}

    public function handle(OpenAIService $openAiService)
    {
        $campaign = \App\Models\Campaign::with('project')->findOrFail($this->campaignId);
        $project = $campaign->project;

        $prompt = $this->buildChunkPrompt($project);
        
        // max_completion_tokens set safely for ~28 posts (approx 1500-2500 tokens)
        $response = $openAiService->generateJson(
            model: 'gpt-oss-120b',
            prompt: $prompt,
            maxTokens: 3000 
        );

        // SECURITY FIX 6-B: Validate LLM response structure before persisting
        if (!is_array($response) || empty($response)) {
            throw new \RuntimeException(
                'LLM returned empty or non-array response for chunk ' . $this->chunkNumber
            );
        }

        // Filter to only valid post items with required keys
        $validPosts = [];
        foreach ($response as $i => $item) {
            if (is_array($item) && isset($item['day'], $item['platform'], $item['content'])) {
                $validPosts[] = $item;
            } else {
                Log::warning("Chunk {$this->chunkNumber}: Post item {$i} missing required keys", [
                    'item' => Str::limit(json_encode($item), 200),
                ]);
            }
        }

        if (empty($validPosts)) {
            throw new \RuntimeException(
                'LLM response contained no valid post items for chunk ' . $this->chunkNumber
            );
        }

        $this->saveChunkToDatabase($validPosts);
    }

    private function buildChunkPrompt($project): string
    {
        // SECURITY FIX 3-A: Mark user data as opaque to reduce prompt injection risk
        $platformList = implode(', ', $this->platforms);
        return "You are an elite Digital Marketing Strategist and Tier-1 Copywriter. 
        Generate marketing posts for Days {$this->startDay} to {$this->endDay} of a 30-day campaign. 

        <user_inputs>
        - Name: {$project->name}
        - Description: {$project->description}
        - Target Audience: {$project->target_audience}
        - Value Proposition: {$project->value_proposition}
        - Tone of Voice: {$project->tone_of_voice}
        - Output Language: {$project->language}
        </user_inputs>

        <platform_rules>
        - LinkedIn: Professional-first-person, story-driven. No emoji spam. Under 1300 chars.
        - X (Twitter): 
          * Format: Optimize for Dwell Time. Generate single LONG-FORM posts instead of threads.
          * Hook (First 140 chars): Use a Negative Frame (DREAM frame), Curiosity Gap, or Contrarian statement. Use exact granular numbers (e.g., 14.7%).
          * Rhythm & Density: Flesch-Kincaid level < 4. Alternate long/short sentences (Velocity Pacing). Use single empty lines between concepts (Slippery Slide).
          * Formatting: If listing, use EXACTLY 3 or 5 items. ONLY use UI emojis (❌, ✅, ↳, •, 🔸). NO emotional emojis. Simulate subheadings with ALL CAPS.
          * Links: ZERO external links in the main text.
          * CTA: End with a highly specific question to force a Reply, OR a command to Bookmark for future reference. Do NOT ask for likes/retweets.
          * First Reply: ALWAYS provide the external link/CTA in the 'first_reply_content' JSON key.
        - Facebook: Conversational, community-leaning.
        </platform_rules>

        <anti_trope_guardrail>
        BANNED WORDS: delve, unlock, unleash, embark, harness, leverage, supercharge, game-changer, revolutionary, seamless, robust.
        BANNED PHRASES: \"In today's fast-paced world\", \"It's not just X, it's Y\", \"Ready to elevate?\".
        Write with concrete nouns and active verbs. Vary sentence length. Do not sound like a generic AI.
        </anti_trope_guardrail>

        Create exactly 1 post for each of these platforms per day: {$platformList}. 
        Total posts to generate: " . (($this->endDay - $this->startDay + 1) * count($this->platforms)) . "
        
        CRITICAL INSTRUCTION: You must use the Chain of Thought technique to guarantee Tier-1 quality.
        CRITICAL INSTRUCTION: You MUST generate all the actual post content in the specified Output Language: {$project->language}. Do not generate content in any other language.
        Return ONLY a valid JSON object with EXACTLY TWO keys in this specific order:
        1. \"_internal_analysis\": (string) Write a strategic report analyzing the brand, audience, and your plan to strictly avoid the banned words in <anti_trope_guardrail> for this chunk. You MUST generate this key FIRST.
        2. \"posts\": (array) An array of objects containing the actual content.

        Each object inside the \"posts\" array must have these exactly named keys: 'day' (integer), 'platform' (string), 'content' (string). For X (Twitter), you may optionally include a 'first_reply_content' (string) key if you need to share a link.";
    }

    private function saveChunkToDatabase(array $posts): void
    {
        $postsData = [];
        foreach ($posts as $postData) {
            $dayNumber = $postData['day'] ?? $this->startDay;

            // SECURITY FIX 9-A: Use tomorrow as base to avoid scheduling posts in the past
            // when a campaign is created late at night.
            $scheduledAt = \Carbon\Carbon::tomorrow($this->timezone)
                ->startOfDay()
                ->addDays($dayNumber - 1)
                ->addHours(9)
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');

            $postsData[] = [
                'campaign_id' => $this->campaignId,
                'day_number' => $dayNumber,
                'platform' => $postData['platform'] ?? 'unknown',
                'content' => $postData['content'] ?? '',
                'first_reply_content' => $postData['first_reply_content'] ?? null,
                'scheduled_at' => $scheduledAt,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($postsData)) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($postsData) {
                Post::insert($postsData);
            }, 3, ['IMMEDIATE']);
        }
    }
}
