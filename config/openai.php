<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Project
    |--------------------------------------------------------------------------
    */

    'project' => env('OPENAI_PROJECT'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Base URL
    |--------------------------------------------------------------------------
    */

    'base_uri' => env('OPENAI_BASE_URL'),

    // CRITICAL FIX: Enforce timeouts at the HTTP client level.
    'client_options' => [
        'timeout' => 60,
        'connect_timeout' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo / Preview Mode — FREE USER TEASER
    |--------------------------------------------------------------------------
    |
    | When `demo_mode` is true, OpenAIService is replaced by StubOpenAIService.
    | The stub produces realistic-looking posts using the user's actual inputs
    | (brand, audience, funnel phase) WITHOUT calling Cerebras.
    |
    | INTENDED USE: Free users in local/dev environment can generate a campaign
    | to preview the result. This is a deliberate conversion funnel — they
    | see realistic output and are motivated to upgrade.
    |
    | Set OPENAI_DEMO_MODE=false to force real LLM (e.g. when testing
    | a paid user's flow in local). Production ALWAYS uses real LLM.
    */
    'demo_mode' => filter_var(
        env('OPENAI_DEMO_MODE', in_array(env('APP_ENV'), ['local', 'testing'], true)),
        FILTER_VALIDATE_BOOLEAN
    ),

    /*
    |--------------------------------------------------------------------------
    | Stub Response Configuration
    |--------------------------------------------------------------------------
    |
    | Controls the shape of canned posts returned by StubOpenAIService when
    | demo_mode is active. Each post is a single-day entry in a 30-day plan.
    */
    'stub' => [
        'days_per_chunk' => 7,
        'sample_template' => [
            'day' => 1,
            'content' => '[DEMO CONTENT] This is a sample Master Post for Day {day}. In live mode, the AI generates unique omnichannel copy tailored to your brand voice, target audience, and funnel phase.',
            'first_reply_content' => 'In live mode, the deep breakdown link and resources would appear here. (Demo Mode — no real LLM call was made.)',
        ],
    ],
];
