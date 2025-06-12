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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'recaptcha' => [
        'score' => 0.29,
        'key' => env('RECAPTCHA_SITE_KEY'),
        'secret' => env('RECAPTCHA_SECRET_KEY'),
    ],

    'plisio' => [
        'secret' => env('PLISIO_SECRET_KEY'),
        'currencies' => [
            'BTC',
            'ETH',
            'USDT',
            'USDT_TRX',
            'USDC',
            'DOGE',
            'BNB',
            'BCH',
            'BUSD',
        ],
    ],

    'passimpay' => [
        'platform_id' => env('PASSIMPAY_PLATFORM_ID'),
        'secret_key' => env('PASSIMPAY_SECRET_KEY'),
        'currencies' => [
            10, 20, 70, 71, 100, 40, 130, 50, 232, 246,
        ],
    ],

];
