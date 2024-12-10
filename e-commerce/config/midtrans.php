<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-_GAUxTYCYmhV6_MfX7AEI6Ni'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-F3XE-h5yeHjlPB8B'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false) ? 
    'https://app.midtrans.com/snap/v1/transactions' : 
    'https://app.sandbox.midtrans.com/snap/v1/transactions',
];