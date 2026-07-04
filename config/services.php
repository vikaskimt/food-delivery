<?php

return [
    'otp' => [
        'length' => env('OTP_LENGTH', 4),
        'expiry_minutes' => env('OTP_EXPIRY_MINUTES', 5),
    ],

    'sms' => [
        'provider' => env('SMS_PROVIDER', 'log'), // log | twilio | msg91 | fast2sms
        'api_key' => env('SMS_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID', 'FOODAPP'),
    ],

    // Add mail/postmark/etc. driver blocks here if/when needed —
    // this file replaces (don't just append to) Laravel's default config/services.php.
];
