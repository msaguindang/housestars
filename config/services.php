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
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'key' => env('pk_test_kn2olHxJ38llq3Ot6g5ViY8Y'),
        'secret' => env('sk_test_qaq6Jp8wUtydPSmIeyJpFKI1'),
    ],

    // // PRINZ CREDENTIALS
    // 'facebook' => [
    //     'client_id' => '1889078964644540',
    //     'client_secret' => '94569d661404d0c28372e6d423e63a03',
    //     'redirect' => 'http://localhost:8000/login/facebook/callback',
    // ],

    // MIKOO CREDENTIALS
    //  'facebook' => [
    //     'client_id' => '1150866285041256',
    //     'client_secret' => '573b3fb2adb5735fe38dbbb3228abbc1',
    //     'redirect' => 'http://localhost:8000/login/facebook/callback',
    // ],

    // 'google' => [
    //     'client_id' => '654636135144-hio9bt216h0jcvdbbmiq5fo1v342gnib.apps.googleusercontent.com',
    //     'client_secret' => 'VzrpCSvLOXQi1Th7YX7UjmKH',
    //     'redirect' => 'http://localhost:8000/login/google/callback'
    // ],

    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    
    'google' => [
        'client_id' => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI')
    ],

    'ses' => [
        'key' => 'AKIAISJHMTUHCEXPM4WA',
        'secret' => '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',
        'region' => 'us-west-2',
    ],
];
