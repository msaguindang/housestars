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

    'facebook' => [
        'client_id' => '1889078964644540',
        'client_secret' => '94569d661404d0c28372e6d423e63a03',
        'redirect' => 'http://localhost/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '469144857452-kq3vdeq6g21vpnaks3vcp1jmlkun2gqk.apps.googleusercontent.com',
        'client_secret' => '3gwuGjqlEnEOeXgUqPCduCLY',
        'redirect' => 'http://localhost/login/google/callback',
    ],

];
