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
        'mode' => env('DODO_MODE', 'test'),
        'webhook_secret' => env('DODO_WEBHOOK_SECRET'),
        'api_key' => env('DODO_API_KEY'),
        'link_1_campaign' => env('DODO_LINK_1_CAMPAIGN'),
        'link_3_campaigns' => env('DODO_LINK_3_CAMPAIGNS'),
        'link_10_campaigns' => env('DODO_LINK_10_CAMPAIGNS'),
        'link_starter_campaign' => env('DODO_LINK_STARTER_CAMPAIGN'),
        'link_pro_campaign' => env('DODO_LINK_PRO_CAMPAIGN'),
        'link_business_campaign' => env('DODO_LINK_BUSINESS_CAMPAIGN'),
        'link_agency_pro_campaign' => env('DODO_LINK_AGENCY_PRO_CAMPAIGN'),
    ],

    'cerebras' => [
        'key' => env('CEREBRAS_API_KEY'),
        'base_url' => env('CEREBRAS_BASE_URL', 'https://api.cerebras.ai/v1'),
    ],

    // PostPeer Unified Social Media API
    'postpeer' => [
        'key' => env('POSTPEER_API_KEY'),
        'base_url' => env('POSTPEER_BASE_URL', 'https://api.postpeer.dev/v1'),
    ],

    'paddle' => [
        'mode' => env('PADDLE_MODE', 'sandbox'),
        'client_side_token' => env('PADDLE_CLIENT_SIDE_TOKEN'),
        'api_key' => env('PADDLE_API_KEY'),
        'webhook_secret' => env('PADDLE_WEBHOOK_SECRET'),
        'price_1_campaign' => env('PADDLE_PRICE_1_CAMPAIGN'),
        'price_3_campaigns' => env('PADDLE_PRICE_3_CAMPAIGNS'),
        'price_10_campaigns' => env('PADDLE_PRICE_10_CAMPAIGNS'),
    ],

    // Direct Twitter API Integration (Bypassing PostPeer)
    'twitter-oauth-2' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI') ?: (env('APP_URL', 'https://postpilot.sbs').'/settings/socials/callback/twitter'),
    ],

];
