<?php
return [
    'wsdl' => env('BRIDGER_WSDL', ''),
    'client_id' => env('BRIDGER_CLIENT_ID', ''),
    'user_id' => env('BRIDGER_USER_ID', ''),
    'password' => env('BRIDGER_PASSWORD', ''),
    'timeout' => env('BRIDGER_TIMEOUT', 15),
    'cache_wsdl' => (bool) env('BRIDGER_CACHE_WSDL', true),
];
