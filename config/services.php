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


    'booking' => [
        'name' => 'booking',
        'base_url' => env('BOOKING_BASE_URL',''),
        'api_key' => env('BOOKING_API_KEY','')
    ],

    'core_clinic' => [
        'name' => 'core clinic',
        'base_url' => env('CORE_CLINIC_BASE_URL',''),
        'api_key' => env('CORE_CLINIC_API_KEY','')
    ],

    'permission' => [
        'name' => 'permission',
        'base_url' => env('PERMISSION_BASE_URL',''),
        'api_key' => env('PERMISSION_API_KEY','')
    ],

];
