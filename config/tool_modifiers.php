<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Programmatic SEO (pSEO) Modifiers
    |--------------------------------------------------------------------------
    |
    | Defines the modifiers for long-tail SEO variations of the core tools.
    | Each tool can have multiple modifier slugs. When a user visits
    | /tools/social-character-counter/twitter, they are hitting the
    | core social-character-counter tool but with the 'twitter' modifier.
    |
    */

    'social-character-counter' => [
        'twitter' => [
            'title' => 'Twitter (X) Character Counter & Limits Tool',
            'meta_description' => 'Check your Twitter (X) character count in real time. Avoid the 280-character limit and format perfect threads before publishing.',
            'h1' => 'Twitter Character Counter',
            'preset_platform' => 'twitter',
        ],
        'linkedin' => [
            'title' => 'LinkedIn Post Character Counter & Formatter',
            'meta_description' => 'Write perfect LinkedIn posts with our real-time character counter. Keep critical hooks visible before the "...see more" fold cutoff.',
            'h1' => 'LinkedIn Character Counter',
            'preset_platform' => 'linkedin',
        ],
        'instagram' => [
            'title' => 'Instagram Caption Character Counter',
            'meta_description' => 'Track your Instagram caption length and hashtag counts to ensure your hook appears before the truncation fold.',
            'h1' => 'Instagram Caption Counter',
            'preset_platform' => 'instagram',
        ],
        'facebook' => [
            'title' => 'Facebook Post Character Counter',
            'meta_description' => 'Optimize your Facebook post length for maximum mobile feed engagement with this free character limit tracker.',
            'h1' => 'Facebook Post Counter',
            'preset_platform' => 'facebook',
        ],
    ],

    'twitter-thread-splitter' => [
        'blog-to-thread' => [
            'title' => 'Blog Post to Twitter Thread Converter',
            'meta_description' => 'Automatically split your long-form blog posts and articles into a numbered Twitter thread with our free converter tool.',
            'h1' => 'Blog to Twitter Thread Converter',
            'preset_text' => "Welcome to our latest blog post!\n\nToday we're covering the top 3 strategies for growth...",
        ],
        'long-tweet' => [
            'title' => 'Long Tweet Formatter & Thread Maker',
            'meta_description' => 'Break long tweets past the 280-character limit into perfectly formatted, auto-numbered threads.',
            'h1' => 'Long Tweet Thread Maker',
            'preset_text' => '',
        ],
    ],
];
