<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * FREE USER TEASER: Stub LLM service for demo / preview paths.
 *
 * Returns realistic-looking posts that use the user's actual brand name,
 * audience, and funnel phase — so free users see exactly what a paid
 * campaign would look like, without burning Cerebras credits.
 *
 * Binds to `OpenAIService` container key when `openai.demo_mode` is true.
 */
class StubOpenAIService extends OpenAIService
{
    public function generateJson(string $model, string $prompt, int $maxTokens = 3000): array
    {
        $daysPerChunk = (int) config('openai.stub.days_per_chunk', 7);

        // Parse the prompt to extract real user inputs
        $inputs = $this->extractUserInputs($prompt);
        $days = $this->extractDayRange($prompt, $daysPerChunk);

        $posts = [];
        for ($day = $days['start']; $day <= $days['end']; $day++) {
            $posts[] = [
                'day' => $day,
                'content' => $this->generateRealisticPost($inputs, $day, $days['chunk'], $days['total']),
                'first_reply_content' => $this->generateRealisticReply($inputs, $day),
            ];
        }

        Log::info('StubOpenAIService served FREE preview (no LLM cost)', [
            'brand' => $inputs['brand'],
            'days' => count($posts),
        ]);

        return $posts;
    }

    private function extractUserInputs(string $prompt): array
    {
        $defaults = [
            'brand' => 'Your Brand',
            'description' => 'your product',
            'audience' => 'your target customers',
            'value_prop' => 'your unique solution',
            'tone' => 'professional',
            'language' => 'English',
        ];

        preg_match('/Brand Name:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['brand'] = trim($m[1]);
        }
        preg_match('/Product Description:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['description'] = trim($m[1]);
        }
        preg_match('/Target Audience:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['audience'] = trim($m[1]);
        }
        preg_match('/Value Proposition:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['value_prop'] = trim($m[1]);
        }
        preg_match('/Tone of Voice:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['tone'] = trim($m[1]);
        }
        preg_match('/Output Language:\s*([^\n-]+)/i', $prompt, $m);
        if ($m) {
            $defaults['language'] = trim($m[1]);
        }

        // Detect funnel phase (Week 1-4)
        preg_match('/Week (\d)/i', $prompt, $m);
        $defaults['week'] = isset($m[1]) ? (int) $m[1] : 1;

        return $defaults;
    }

    private function extractDayRange(string $prompt, int $defaultChunk): array
    {
        $start = 1;
        $end = $defaultChunk;
        if (preg_match('/Days?\s+(\d+)\s+to\s+(\d+)/i', $prompt, $m)) {
            $start = max(1, (int) $m[1]);
            $end = min(30, (int) $m[2]);
        }
        if (preg_match('/Chunk (\d+) of (\d+)/i', $prompt, $m)) {
            $chunk = (int) $m[1];
            $total = (int) $m[2];
        } else {
            $chunk = 1;
            $total = 5;
        }

        return ['start' => $start, 'end' => $end, 'chunk' => $chunk, 'total' => $total];
    }

    private function generateRealisticPost(array $inputs, int $day, int $chunk, int $total): string
    {
        $brand = $inputs['brand'];
        $audience = $inputs['audience'];
        $value = $inputs['value_prop'];

        // Pick a hook based on the day
        $hooks = [
            "Most {$audience} get this wrong on day one.",
            'Stop scrolling. This changes everything.',
            'I wasted 3 years before I learned this.',
            "The {$brand} team tested 47 strategies. Here's what worked.",
            "If you're a {$audience}, read this twice.",
            "The brutal truth nobody tells {$audience}.",
            "Day {$day} of 30. Here's what we learned.",
        ];
        $hook = $hooks[$day % count($hooks)];

        // Pick a body based on week (funnel phase)
        $bodies = [
            1 => "We surveyed 200 {$audience} and found 73% make the same mistake. They chase tactics before fundamentals.\n\nThe result? Burnout. Inconsistent results. A calendar full of guesswork.\n\n{$brand} exists because we lived this. We built {$value} after watching every 'shiny object' fail.\n\nHere's the truth: most strategies work IF you commit. The problem isn't the strategy. It's the switching.",
            2 => "The industry loves to repeat myths. Let me destroy three.\n\nMYTH 1: 'Post more = grow faster.' False. 14.7% of high-performing accounts post just 3x/week.\n\nMYTH 2: 'Engagement equals value.' Wrong. Saves and replies weight 10x more than likes.\n\nMYTH 3: 'AI content gets penalized.' Only if it's lazy. {$brand} uses AI as a co-pilot, not a replacement.\n\nThe real framework is simpler than you think.",
            3 => "After running {$brand} for 6 months, here's our exact playbook.\n\n✅ Hook in 140 chars or less\n✅ Pattern interrupt in line 1\n✅ Specific numbers (not 'many' — actual data)\n✅ CTA that triggers saves, not likes\n\nWe went from 0 to 12K followers using this exact structure. The framework isn't magic. It's just consistent application.\n\nTry it for 30 days. Report back.",
            4 => "In 72 hours, our pricing changes.\n\nIf you've been on the fence about {$value}, this is your window.\n\nWe tested three different offers this month. The data was clear: founders who started in week 1 hit profitability 2.3x faster than those who waited.\n\nThe cost of inaction compounds. Every week you delay is a week your competitors are building the habit your audience rewards.\n\nReady? Link in the first comment.",
        ];
        $body = $bodies[$inputs['week']] ?? $bodies[1];

        // CTA based on day
        $ctas = [
            'Bookmark this. Then tell me your biggest struggle below.',
            'Try this for 7 days. Report back with your results.',
            'Tag someone who needs to read this today.',
            "Drop a 🙋 if you've made this mistake before.",
            'Save this for your next strategy session.',
            "Predict where you'll be in 90 days. I'll reply to everyone.",
        ];
        $cta = $ctas[$day % count($ctas)];

        return "{$hook}\n\n{$body}\n\n{$cta}";
    }

    private function generateRealisticReply(array $inputs, int $day): string
    {
        $brand = $inputs['brand'];

        return "📌 Full breakdown + templates in the first comment.\n\n"
             ."If you want the exact prompts we used at {$brand} to scale to 12K followers in 90 days — "
             ."the link is below.\n\n"
             ."⚠️ Limited spots: we're opening 50 new accounts this month.";
    }
}
