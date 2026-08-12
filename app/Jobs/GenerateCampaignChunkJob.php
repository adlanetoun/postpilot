<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CreditTransaction;
use App\Models\Post;
use App\Services\OpenAIService;
use App\Services\StubOpenAIService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        protected array|string $platforms,
        protected string $timezone = 'UTC',
        protected float $autonomyLevel = 0.3
    ) {
        if (is_string($this->platforms)) {
            $decoded = json_decode($this->platforms, true);
            $this->platforms = is_array($decoded) ? $decoded : [$this->platforms];
        }
        if (! is_array($this->platforms)) {
            $this->platforms = ['linkedin', 'twitter', 'facebook'];
        }
    }

    public function handle(OpenAIService $openAiService)
    {
        // SILENT EARLY EXIT: If the batch was cancelled or the campaign was deleted/halted,
        // exit quietly without calling the LLM API or throwing exceptions/FAIL logs in queue worker.
        if ($this->batch()?->cancelled()) {
            Log::info("GenerateCampaignChunkJob #{$this->chunkNumber} skipped — batch was cancelled.");

            return;
        }

        $campaign = Campaign::with('project.user')->find($this->campaignId);
        if (! $campaign || $campaign->status !== 'generating') {
            Log::info("GenerateCampaignChunkJob #{$this->chunkNumber} skipped — campaign {$this->campaignId} deleted or no longer generating.");

            return;
        }

        $project = $campaign->project;
        $user = $project->user;

        // ONE-TIME FREE DEMO: User gets exactly ONE demo campaign in their
        // account lifetime (tracked via users.has_used_demo). After that,
        // they must purchase credits to generate anything — even more demos.
        $isDemoGeneration = $user->canUseFreeDemo();
        $llmService = $isDemoGeneration
            ? new StubOpenAIService
            : $openAiService;

        // Mark the campaign as demo + flip the user's one-time flag
        if ($isDemoGeneration && ! $campaign->is_demo) {
            $campaign->update(['is_demo' => true]);
            $user->markDemoUsed();
        }

        $prompt = $this->buildChunkPrompt($campaign, $project);

        // max_completion_tokens set safely for ~28 posts (approx 1500-2500 tokens)
        $response = $llmService->generateJson(
            model: config('services.cerebras.model', 'gpt-oss-120b'),
            prompt: $prompt,
            maxTokens: 5000
        );

        // SECURITY FIX 6-B: Validate LLM response structure before persisting
        if (! is_array($response) || empty($response)) {
            throw new \RuntimeException(
                'LLM returned empty or non-array response for chunk '.$this->chunkNumber
            );
        }

        // Filter to only valid post items with required keys
        $validPosts = [];
        foreach ($response as $i => $item) {
            if (is_array($item) && isset($item['day'], $item['content'])) {
                $validPosts[] = $item;
            } else {
                Log::warning("Chunk {$this->chunkNumber}: Post item {$i} missing required keys", [
                    'item' => Str::limit(json_encode($item), 200),
                ]);
            }
        }

        if (empty($validPosts)) {
            throw new \RuntimeException(
                'LLM response contained no valid post items for chunk '.$this->chunkNumber
            );
        }

        $this->saveChunkToDatabase($validPosts);
    }

    private function buildChunkPrompt($campaign, $project): string
    {
        // SECURITY FIX 3-A: Mark user data as opaque to reduce prompt injection risk
        $platformList = implode(', ', $this->platforms);
        $weekPhase = min(4, $this->chunkNumber);
        $funnelText = match ($weekPhase) {
            1 => 'Week 1 (Awareness): The psychological goal is Pattern Interrupt & Problem Awareness. Focus on uncovering hidden mistakes, hidden costs, and the pain of the status quo.',
            2 => "Week 2 (Education): The psychological goal is Paradigm Shift & Education. Focus on destroying industry myths, telling personal stories of failure/learning, and revealing 'what they don't know'.",
            3 => 'Week 3 (Trust): The psychological goal is Social Proof & Solution Frameworks. Focus on actionable steps, systems, case studies, and building authority.',
            default => 'Week 4 (Conversion): The psychological goal is Urgency & Action. Focus on the cost of inaction, scarcity, immediate next steps, and strong conviction.'
        };
        $diversitySeed = ($this->campaignId * 10) + $this->chunkNumber;

        $prompt = "You are simultaneously three experts working as one: (1) a Direct-Response Copywriter with 20 years of experience, (2) an Algorithmic Growth Engineer who has reverse-engineered the recommendation systems of X, LinkedIn, and Facebook, and (3) a Behavioral Psychologist specializing in Loss Aversion and Curiosity Gaps.

        Your mission: Generate ONE legendary 'Omnichannel Master Post' per day for Days {$this->startDay} to {$this->endDay} of a 30-day campaign. This single post will be published identically across {$platformList}.

        <campaign_funnel_and_diversity>
        You are generating Chunk {$this->chunkNumber} of the campaign.
        FUNNEL PHASE: {$funnelText}
        Your hooks and content MUST strictly align with this psychological goal. Do NOT use angles from other weeks.
        
        DIVERSITY SEED: {$diversitySeed}
        You MUST follow the EXACT structure and CTA style assigned to each day in the <per_day_blueprint> section below. Do NOT deviate. Do NOT blend multiple structures into one post.
        </campaign_funnel_and_diversity>";

        if ($this->autonomyLevel > 0.0) {
            $prompt .= $this->buildAutonomySection($this->autonomyLevel);
        }

        $perDayBlueprint = $this->buildPerDayBlueprint();

        $prompt .= "

        <user_inputs>
        - Brand Name: {$project->name}
        - Product Description: {$campaign->description}
        - Target Audience: {$campaign->target_audience}
        - Value Proposition: {$campaign->value_proposition}
        - Tone of Voice: {$campaign->tone_of_voice}
        - Output Language: {$campaign->language}
        </user_inputs>

        {$perDayBlueprint}

        <golden_length_constraint>
        MANDATORY: Each Master Post MUST be between 1,300 and 1,900 characters (approximately 200-300 words).
        - Posts shorter than 1,300 chars are classified as 'low-effort' by all 3 algorithms and get suppressed.
        - Posts longer than 1,900 chars suffer a 35% engagement drop due to cognitive fatigue.
        - This range forces a 45-60 second read time, which triggers 'Maximum Distribution' in LinkedIn's 360Brew engine and earns a +10 Dwell Time bonus in X's Phoenix algorithm.
        </golden_length_constraint>

        <hook_architecture>
        THE FIRST 140 CHARACTERS ARE LIFE OR DEATH. All 3 platforms truncate text behind a 'See More' button at ~140 chars.
        You MUST structure the opening as a 3-line psychological weapon:

        LINE 1 — 'Pattern Interrupt' (max 50 chars): A short, brutal, scroll-stopping statement. No greetings, no introductions.
        LINE 2 — 'Negative Escalation' (max 70 chars): Deepen the information gap using Loss Aversion. Present a hidden threat, a costly mistake, or a counter-intuitive data point with EXACT numbers (e.g., 66%, 14.7%, NOT 'many' or 'most').
        LINE 3 — 'Payoff Promise' (max 30 chars): A short bridge that forces the physical click on 'See More'.

        CRITICAL: Insert a HARD LINE BREAK (empty line) immediately after Line 3. The 'See More' button must land in visual silence.
        CRITICAL: The first 3 lines must ONLY present the problem or the shock. NEVER reveal the solution above the fold.
        </hook_architecture>

        <omnichannel_tone>
        For EACH day, you MUST use ONLY the tone archetype assigned in <per_day_blueprint> above.
        DO NOT blend multiple archetypes in a single post. Each post must feel structurally DIFFERENT from the others in this chunk.

        The archetype families and their algorithmic purpose:
        - STORY archetypes (Thread-Style Micro-Story, Confession, Open Letter) → trigger Facebook emotional resonance engine and X reply-generation.
        - DATA archetypes (Data Bomb, Listicle with Twist) → trigger LinkedIn 360Brew Depth Score for professional authority and saves.
        - ARGUMENT archetypes (Myth Destroyer, Contrarian Confession) → trigger X debate algorithm and LinkedIn thought-leadership signals.
        - TRANSFORMATION archetypes (Before/After) → trigger emotional sharing across all 3 platforms.

        CRITICAL ANTI-REPETITION RULE: If you catch yourself writing the same subheading pattern (e.g., THE REAL PROBLEM → PERSONAL STORY → HERE IS WHAT WORKS) in more than ONE post within this chunk, STOP and restructure. Each post MUST have a UNIQUE internal skeleton that matches its assigned archetype.
        </omnichannel_tone>

        <anti_repetition_banned_phrases>
        The following phrases are BANNED from being reused across the 30-day campaign. Each may appear AT MOST ONCE across ALL posts:
        - Any variation of 'اكتشف الحقيقة الآن' / 'Discover the truth now'
        - Any variation of 'اعترف' / 'أعترف' / 'Confess' as a CTA
        - 'تحدي 3 أيام' / '3-day challenge' — use AT MOST 1 time in the entire campaign
        - 'شاركنا في التعليقات' / 'Share in the comments' as a closing CTA
        - 'احفظ هذه القائمة' / 'Save this list'
        If you catch yourself repeating ANY of these across multiple posts, you MUST rewrite the CTA to be completely unique.
        Each post's closing line must feel like it was written by a DIFFERENT copywriter.
        </anti_repetition_banned_phrases>

        <natural_language_rule>
        ABSOLUTE BAN on using internal structural labels as visible text in the post.
        BANNED label patterns (in any language):
        - 'إحصائية 1:', 'إحصائية 2:', 'الإحصائية الأولى:', etc.
        - 'التحليل:', 'تحليل:', 'تحليل سريري:', 'النتيجة:', 'دليل:', 'دليل علمي:'
        - 'SCENE 1:', 'SCENE 2:', 'المشهد الأول:', 'المشهد الثاني:'
        - 'MYTH DESTROYER:', 'CONTRARIAN CONFESSION:'
        - Any text that reads like a section header or internal instruction rather than natural prose.
        Instead, weave the analysis, evidence, and narrative transitions INLINE as flowing natural prose.
        The reader should feel like they are reading a human's authentic social media post, NOT a structured report.
        </natural_language_rule>

        <brand_identity_integration>
        CRITICAL — The brand name '{$project->name}' MUST appear naturally in EVERY post at least once.
        The product's key selling points from the description MUST be woven into the narrative — not as a separate sales paragraph, but as a natural part of the story or argument.

        WEEK-SPECIFIC BRAND RULES:
        - Week 1-2 (Awareness/Education): Mention the brand name once, subtly, as part of the narrative. The focus is on the PROBLEM, not the product. Example: 'That is exactly why we built [Brand Name]' or 'At [Brand Name], we tested this ourselves.'
        - Week 3 (Trust): Mention the brand name 1-2 times. Include ONE specific product feature or benefit from the user's description. Example: 'Our [specific feature] was designed to solve exactly this.'
        - Week 4 (Conversion): Mention the brand name 2-3 times. Include a SOFT commercial call-to-action woven into the closing. Examples:
          • 'Ready to try it? Link in the first comment.'
          • 'We are offering [specific offer from description] — details in the first comment.'
          • 'Start your first order today — [Brand Name] delivers [specific benefit].'
        
        IMPORTANT: NEVER invent product features, prices, offers, or promotions that are NOT explicitly stated in the user's Product Description. If the user said 'free delivery for bulk orders', you may mention it. If they did NOT mention a discount, do NOT invent one.
        </brand_identity_integration>

        <text_ui_rules>
        Treat the post as a User Interface, NOT a paragraph:
        - ABSOLUTE BAN on text walls exceeding 3 consecutive lines without a line break.
        - Insert a full empty line after every 1-2 strong sentences (Slippery Slide technique).
        - Use 'Sentence Velocity Pacing': alternate SHORT punchy sentences (5-8 words) with LONGER analytical sentences (15-25 words). This rhythm creates reading momentum.
        - If listing items: use EXACTLY 3 or 5 items (odd numbers create Pattern Disruption and cognitive tension, forcing the reader to finish the list).
        - Simulate subheadings using ALL CAPS for key transitions (e.g., 'THE REAL PROBLEM:', 'HERE IS WHAT WORKS:').
        - ONLY use structural UI emojis as visual punctuation: ✅, ❌, ↳, •, 🔸, 📌, ➖. ABSOLUTELY NO emotional emojis (😂, 🔥, 🚀, 💡, etc.).
        - Maximum 1 highly specific hashtag at the very end. Zero hashtag stuffing.
        </text_ui_rules>

        <link_quarantine>
        ZERO external links (http/https/www) in the main post text. All 3 platforms (X, LinkedIn, Facebook) algorithmically suppress posts containing outbound links by 60-94%.
        ALWAYS place the link, resource, or signup URL in the 'first_reply_content' JSON field. The main post must end by directing users to the first comment (e.g., 'Full breakdown in the first comment below.').
        </link_quarantine>

        <universal_cta_formula>
        The final CTA for each post MUST follow the specific CTA STYLE assigned in <per_day_blueprint> above.
        DO NOT use the same CTA wording or structure across multiple days. Each CTA must feel fresh and unique.

        Algorithmic purpose: CTAs must trigger SAVES (weight: +10 on X, +3-5x on LinkedIn) and DEEP COMMENTS (weight: +13.5 on X, +15x on LinkedIn).
        NEVER ask for likes, retweets, or shares. These carry the LOWEST algorithmic weight (1x baseline).

        ANTI-REPETITION CHECK: If you find yourself writing 'Bookmark this for your next strategy session. Then tell me:' more than ONCE across all posts in this chunk, you have FAILED the diversity test. Each CTA must be uniquely crafted based on its assigned CTA STYLE.
        </universal_cta_formula>

        <anti_trope_guardrail>
        The AI-detection filters of Grok (X), LinkedIn Quality Filters, and Facebook's Andromeda system penalize generic AI-generated text by up to 25% reach reduction.
        ABSOLUTELY BANNED VOCABULARY:
        - Verbs: delve, unlock, unleash, embark, harness, leverage, supercharge, elevate, navigate, streamline, optimize (when used as filler).
        - Nouns/Adjectives: game-changer, revolutionary, seamless, robust, tapestry, testament, realm, beacon, landscape, journey, cutting-edge.
        - Connectors: moreover, furthermore, consequently, additionally, it is worth noting.
        - Cliché Phrases: 'In today\\'s fast-paced world', 'Navigating the ever-evolving landscape', 'It\\'s not just X, it\\'s Y', 'Ready to elevate?', 'Let that sink in', 'Here\\'s the thing'.
        INSTEAD: Use concrete technical nouns, active kinetic verbs, direct-response marketing language, and sharp analytical phrasing. Human text has rough edges, abrupt transitions, and problem-solving brutality.
        </anti_trope_guardrail>

        <chain_of_thought_mandate>
        Before writing each Master Post, you MUST perform this internal process (write it in '_internal_analysis'):
        STEP 1: Write 3 different Hook candidates (each under 140 chars) using different psychological triggers.
        STEP 2: Play the role of a 'Brutal Critic' and evaluate which Hook creates the strongest Curiosity Gap and Loss Aversion. Pick the winner.
        STEP 3: Write the full Master Post draft using the winning Hook.
        STEP 4: Scan the draft and DELETE any sentence that does not add concrete value (No Fluff Policy). Replace any complex word with a simpler one.
        STEP 5: Verify character count is between 1,300-1,900 chars. Adjust if needed.
        STEP 6: Output the final polished Master Post.
        </chain_of_thought_mandate>

        Create exactly 1 Master Post for each day from Day {$this->startDay} to {$this->endDay}.
        Total Master Posts to generate: ".($this->endDay - $this->startDay + 1)."

        CRITICAL INSTRUCTION: You MUST generate ALL post content in the specified Output Language: {$campaign->language}. The '_internal_analysis' can be in English, but the 'content' and 'first_reply_content' MUST be in {$campaign->language}.
        Return ONLY a valid JSON object with EXACTLY TWO keys in this specific order:
        1. \"_internal_analysis\": (string) Your full Chain of Thought process: Hook candidates, critique, draft analysis, and banned-word verification for this chunk. You MUST generate this key FIRST.
        2. \"posts\": (array) An array of objects containing the final polished content.

        Each object inside the \"posts\" array must have these exactly named keys: 'day' (integer), 'content' (string), and 'first_reply_content' (string). (Do NOT include a 'platform' key).";

        return $prompt;
    }

    private function buildAutonomySection(float $level): string
    {
        $strictness = match (true) {
            $level <= 0.2 => 'MINIMAL: You may make ONLY 1 slight lateral suggestion about audience or angle.',
            $level <= 0.5 => 'MODERATE: You may infer up to 2 lateral audiences AND 2 hidden angles that the user did not mention. But you must STILL prioritize the user\'s stated inputs.',
            $level <= 0.8 => 'AGGRESSIVE: You may infer up to 4 lateral audiences AND 4 hidden pain points. Split posts 50/50 between user-stated and AI-inferred angles.',
            default => 'MAXIMUM: You are a Strategic Autonomy Agent. For at least 70% of posts, invent hidden angles, lateral audiences, and unstated pain points. The user trusts your strategic judgment completely.'
        };

        return "
        <strategic_autonomy_level_{$level}>
        You have been granted Strategic Autonomy by the user (Level {$level}).
        {$strictness}

        <lateral_thinking_requirements>
        When generating posts:
        1. AUDIENCE LATERALITY: For each post, consider if there is a SECONDARY audience segment that would also benefit from this product but wasn't mentioned by the user. Example: if the user says 'marketers', consider also 'founders who do their own marketing' or 'sales teams transitioning to marketing'.
        2. HIDDEN ANGLE DETECTION: Identify marketing angles that are counter-intuitive or non-obvious. Ask: 'What is the OPPOSITE of what everyone else says about this niche?'
        3. UNSTATED PAIN POINTS: Infer 2-3 pain points the user didn't mention. Look for the 'pain behind the pain.' Example: if the user says 'content creation takes too long', the hidden pain might be 'imposter syndrome from inconsistent posting quality.'
        4. COMPETITIVE BLIND SPOTS: Imagine what a competitor would NEVER say about this market. Say it.
        </lateral_thinking_requirements>

        <autonomy_constraints>
        CRITICAL BOUNDARIES — You MUST obey:
        - NEVER contradict or override the user's explicit inputs. Lateral suggestions are ADDITIVE, not REPLACEMENT.
        - NEVER fabricate statistics, case studies, data points, or research citations. You may infer PSYCHOLOGICAL insights but NEVER invent NUMERICAL claims. If you want to use a number, use only well-known, verifiable facts or use qualitative language ('most experts agree', 'research suggests', 'many families find').
        - NEVER invent promotional offers, discounts, free trials, or product features not explicitly mentioned in the user's Product Description.
        - If you invent a lateral audience, label it with [LATERAL] prefix in the _internal_analysis.
        - At least 50% of posts must DIRECTLY use the user's stated target_audience and value_proposition.
        </autonomy_constraints>

        <internal_analysis_addition>
        In your _internal_analysis, AFTER the standard chain-of-thought, add this section:
        === STRATEGIC AUTONOMY AUDIT ===
        - Lateral Audiences Inferred: [list]
        - Hidden Angles Discovered: [list]
        - Unstated Pain Points Identified: [list]
        </internal_analysis_addition>
        </strategic_autonomy_level_{$level}>";
    }

    private function buildPerDayBlueprint(): string
    {
        $structures = [
            'Thread-Style Micro-Story: Tell a sequential 5-scene narrative with a twist ending. NO lists, NO frameworks — pure storytelling momentum.',
            'Data Bomb: Open with 3 shocking, specific statistics. Analyze them clinically. NO personal stories — let the numbers make the argument.',
            'Myth Destroyer: State a widely-believed industry myth in the opening, then systematically demolish it with evidence and logic. NO personal anecdotes.',
            'Before/After Transformation: Paint a vivid BEFORE state of pain, then show the dramatic AFTER state. Structure as a journey arc, NOT a list.',
            'Listicle with Twist: Present 5 numbered items where the LAST item is a surprising contradiction or reversal of the first 4.',
            'Open Letter: Address a specific persona directly (Dear founder who..., To every marketer who...). Conversational, confrontational, deeply personal.',
            'Contrarian Confession: Start with a personal admission that contradicts your professional stance. Build credibility through vulnerability, not authority.',
        ];

        $ctas = [
            'Bookmark + Specific Question: End with a save command tied to a specific use case, then ask a unique question about their personal experience.',
            'Challenge/Dare: End with a 3-day challenge — give a specific action and predict a specific outcome. Ask them to report back.',
            'Poll/Vote: End with a binary choice (A or B?) and ask them to drop their answer below.',
            'Tag Someone: End with a tag prompt — specify the TYPE of person who needs to read this and WHY.',
            'Confession Prompt: End by asking the reader to admit a specific relatable failure. Make it safe and judgment-free.',
            'Prediction: End with a bold 6-month prediction about the industry. Ask for their counter-prediction.',
            'Resource Drop: End with a teaser about a detailed breakdown or template available in the first comment below.',
        ];

        $result = "<per_day_blueprint>\n";
        $result .= "        MANDATORY: Each day MUST follow its assigned STRUCTURE and CTA STYLE exactly. Using a different structure or CTA than assigned is FORBIDDEN.\n\n";

        for ($day = $this->startDay; $day <= $this->endDay; $day++) {
            $structIdx = ($day - 1 + $this->campaignId) % count($structures);
            $ctaIdx = ($day - 1 + $this->campaignId + 3) % count($ctas);
            $result .= "        Day {$day}:\n";
            $result .= "          → STRUCTURE: {$structures[$structIdx]}\n";
            $result .= "          → CTA STYLE: {$ctas[$ctaIdx]}\n\n";
        }

        $result .= '        </per_day_blueprint>';

        return $result;
    }

    private function saveChunkToDatabase(array $posts): void
    {
        // Inherit the demo flag from the parent campaign so every post
        // is uniformly marked and the publishing cron can skip them.
        $campaignIsDemo = Campaign::where('id', $this->campaignId)->value('is_demo') ?? false;

        $postsData = [];
        foreach ($posts as $postData) {
            $dayNumber = $postData['day'] ?? $this->startDay;

            // SECURITY FIX 9-A: Use tomorrow as base to avoid scheduling posts in the past
            // when a campaign is created late at night.
            $scheduledAt = Carbon::tomorrow($this->timezone)
                ->startOfDay()
                ->addDays($dayNumber - 1)
                ->addHours(9)
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');

            $postsData[] = [
                'campaign_id' => $this->campaignId,
                'day_number' => $dayNumber,
                'platform' => 'omnichannel',
                'is_demo' => $campaignIsDemo,
                'content' => $postData['content'] ?? '',
                'first_reply_content' => $postData['first_reply_content'] ?? null,
                'scheduled_at' => $scheduledAt,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (! empty($postsData)) {
            DB::transaction(function () use ($postsData) {
                Post::insert($postsData);
            }, 3, ['IMMEDIATE']);
        }
    }

    /**
     * FIX LEAK-3: Record partial-failure metadata for revenue accounting.
     *
     * When a chunk job is permanently failed after exhausting all `$tries`,
     * the LLM tokens were consumed but the campaign only delivered partial
     * posts. The campaign-level `expected_post_count` is decremented so
     * downstream auditing can detect under-delivery, and a `partial_refund`
     * flag is recorded in the CreditTransaction ledger so finance can issue
     * a goodwill refund for the days the user was charged for but didn't
     * receive.
     *
     * NOTE: We do NOT auto-refund here because the campaign may have other
     * chunks that succeed. The credit deduction happens at `approve()` time
     * (one credit per 30-day campaign, regardless of partial generation).
     * This method only records forensic metadata; refund logic lives in
     * GenerateCampaignJob's batch failure handler.
     */
    public function failed(\Throwable $exception): void
    {
        $campaign = Campaign::find($this->campaignId);
        if (! $campaign) {
            return;
        }

        $platformCount = is_array($this->platforms) ? count($this->platforms) : 1;
        $expectedPosts = ($this->endDay - $this->startDay + 1) * $platformCount;

        Log::warning('GenerateCampaignChunkJob permanently failed', [
            'campaign_id' => $this->campaignId,
            'chunk_number' => $this->chunkNumber,
            'total_chunks' => $this->totalChunks,
            'expected_post_count' => $expectedPosts,
            'start_day' => $this->startDay,
            'end_day' => $this->endDay,
            'platforms' => $this->platforms,
            'error' => Str::limit($exception->getMessage(), 250),
        ]);

        // Atomically decrement the campaign's expected_post_count so we can
        // measure under-delivery vs. credit charged. Use a guarded UPDATE so
        // concurrent chunk failures can't drive the counter below zero.
        DB::table('campaigns')
            ->where('id', $this->campaignId)
            ->where('expected_post_count', '>=', $expectedPosts)
            ->update([
                'expected_post_count' => DB::raw('expected_post_count - '.(int) $expectedPosts),
                'error_message' => 'Chunk '.$this->chunkNumber.' failed after retries: '.Str::limit($exception->getMessage(), 200),
                'updated_at' => now(),
            ]);

        // Record partial_refund ledger entry for finance auditing.
        // This is a non-balance ledger marker; actual refund issuance
        // happens in GenerateCampaignJob's batch catch handler.
        $user = $campaign->project?->user;
        if ($user) {
            CreditTransaction::create([
                'type' => 'partial_refund_marker',
                'amount' => 0,
                'balance_after' => $user->campaign_credits,
                'description' => "Chunk {$this->chunkNumber} failed; expected {$expectedPosts} posts not delivered",
                'idempotency_key' => 'chunk_fail_'.$this->campaignId.'_'.$this->chunkNumber.'_'.now()->timestamp,
                'reference_type' => Campaign::class,
                'reference_id' => $this->campaignId,
                'metadata' => [
                    'chunk_number' => $this->chunkNumber,
                    'expected_post_count' => $expectedPosts,
                    'start_day' => $this->startDay,
                    'end_day' => $this->endDay,
                    'platforms' => $this->platforms,
                    'error' => Str::limit($exception->getMessage(), 250),
                ],
            ]);
        }
    }
}
