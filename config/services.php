<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'dodo' => [
        'webhook_secret' => env('DODO_WEBHOOK_SECRET'),
        'api_key' => env('DODO_API_KEY'),
    ],

    'cerebras' => [
        'key' => env('CEREBRAS_API_KEY'),
        'base_url' => env('CEREBRAS_BASE_URL', 'https://api.cerebras.ai/v1'),
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT_URI', 'http://127.0.0.1:8000/settings/socials/callback/linkedin'),
        'guzzle' => [
            'verify' => file_exists(base_path('storage/cacert.pem')) ? base_path('storage/cacert.pem') : true,
        ],
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI', 'http://127.0.0.1:8000/settings/socials/callback/twitter'),
        'guzzle' => [
            'verify' => file_exists(base_path('storage/cacert.pem')) ? base_path('storage/cacert.pem') : true,
        ],
    ],

    'twitter-oauth-2' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI', 'http://127.0.0.1:8000/settings/socials/callback/twitter'),
        'guzzle' => [
            'verify' => file_exists(base_path('storage/cacert.pem')) ? base_path('storage/cacert.pem') : true,
        ],
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', 'http://127.0.0.1:8000/settings/socials/callback/facebook'),
        'guzzle' => [
            'verify' => file_exists(base_path('storage/cacert.pem')) ? base_path('storage/cacert.pem') : true,
        ],
    ],

];
