<?php

return [
    # System
    'GET api/v1/system/version' => 'rest/system/version-get-one',

    # Currency
    'GET api/v1/currency' => 'rest/currency/get-all',
    'GET api/v1/currency/<code:\w+>' => 'rest/currency/get-one',
    'GET api/v1/currency/<code:\w+>/exchange' => 'rest/currency/exchange-get-all',

    # Web
    'GET converter' => 'web/converter/index'
];
