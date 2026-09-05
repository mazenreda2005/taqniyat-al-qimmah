<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Bank Transfer Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for bank transfer payment method
    |
    */

    'bank' => [
        'name' => env('BANK_NAME', 'البنك الأهلي السعودي'),
        'account_name' => env('BANK_ACCOUNT_NAME', 'تقنيات القمة للتجارة'),
        'iban' => env('BANK_IBAN', 'SA1234567890123456789012'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for payment gateways (Visa/Mada, STC Pay, Tamara)
    | These should be configured in .env file
    |
    */

    'gateways' => [
        'visa_mada' => [
            'enabled' => env('VISA_MADA_ENABLED', true),
            'test_mode' => env('VISA_MADA_TEST_MODE', true),
            'api_key' => env('VISA_MADA_API_KEY'),
            'merchant_id' => env('VISA_MADA_MERCHANT_ID'),
            'callback_url' => env('VISA_MADA_CALLBACK_URL'),
        ],

        'stc_pay' => [
            'enabled' => env('STC_PAY_ENABLED', true),
            'test_mode' => env('STC_PAY_TEST_MODE', true),
            'api_key' => env('STC_PAY_API_KEY'),
            'merchant_id' => env('STC_PAY_MERCHANT_ID'),
            'callback_url' => env('STC_PAY_CALLBACK_URL'),
        ],

        'tamara' => [
            'enabled' => env('TAMARA_ENABLED', true),
            'test_mode' => env('TAMARA_TEST_MODE', true),
            'api_key' => env('TAMARA_API_KEY'),
            'merchant_id' => env('TAMARA_MERCHANT_ID'),
            'callback_url' => env('TAMARA_CALLBACK_URL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */

    'currency' => env('PAYMENT_CURRENCY', 'SAR'),
    'receipt_max_size' => env('RECEIPT_MAX_SIZE', 2048), // KB
    'receipt_allowed_types' => ['jpeg', 'jpg', 'png', 'pdf'],
];
