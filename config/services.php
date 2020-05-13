<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'facebook' => [
        'client_id'     => env('CONF_facebookapp'),
        'client_secret' => env('CONF_facebookappsecret'),
        'redirect'      => env('CONF_facebook_login_callback', '/auth/social/facebook/callback'),
    ],
    'twitter' => [
        'client_id'     => env('CONF_twitterapp'),
        'client_secret' => env('CONF_twitterappsecret'),
        'redirect'      => env('CONF_twitter_login_callback', '/auth/social/twitter/callback'),
    ],
    'google' => [
        'client_id'     => env('CONF_googleapp'),
        'client_secret' => env('CONF_googleappsecret'),
        'redirect'      => env('CONF_google_login_callback', '/auth/social/google/callback'),
    ],
    'vkontakte' => [
        'client_id'     => env('CONF_VKONTAKTE_KEY'),
        'client_secret' => env('CONF_VKONTAKTE_SECRET'),
        'redirect'      => env('CONF_vkontakte_login_callback', '/auth/social/vkontakte/callback'),
    ],
];
