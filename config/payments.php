<?php

$statusBaseUrl = env('PAYMENT_STATUS_BASE_URL');

if (! is_string($statusBaseUrl) || $statusBaseUrl === '') {
    $frontendUrl = env('FRONTEND_URL');
    $appUrl = env('APP_URL', 'http://localhost:8000');
    $statusBaseUrl = is_string($frontendUrl) && $frontendUrl !== ''
        ? rtrim($frontendUrl, '/').'/payments'
        : rtrim((string) $appUrl, '/').'/payments';
}

return [
    'default' => env('PAYMENT_PROVIDER', 'paypal'),
    'store_currency' => env('STORE_CURRENCY', 'KZT'),
    'status_page_base_url' => rtrim((string) $statusBaseUrl, '/'),

    'providers' => [
        'fake' => [
            'currency' => env('FAKE_PAYMENT_CURRENCY', env('STORE_CURRENCY', 'KZT')),
            'exchange_rate' => (string) env('FAKE_PAYMENT_EXCHANGE_RATE', '1'),
            'checkout_flow' => 'hosted_fields',
        ],
        'paypal' => [
            'sandbox' => (bool) env('PAYPAL_SANDBOX', true),
            'base_url' => env('PAYPAL_BASE_URL', 'https://api-m.sandbox.paypal.com'),
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'merchant_id' => env('PAYPAL_MERCHANT_ID'),
            'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
            'currency' => env('PAYPAL_CURRENCY', env('PAYMENT_CURRENCY', 'USD')),
            'exchange_rate' => (string) env('PAYPAL_EXCHANGE_RATE', '510'),
            'checkout_flow' => 'hosted_fields',
        ],
    ],
];
