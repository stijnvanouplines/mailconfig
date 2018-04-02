<?php

return [
    'company_name' => 'My Company',
    'company_url' => 'https://mycompany.com',

    'domain' => 'mailconfig.mycompany.com',
    'domain_required' => true,
    'ttl' => '168',

    'language_dir' => '../languages',
    'fallback_locale' => 'en',
 
    'imap' => [
        'host' => 'imap.mycompany.com',
        'port' => '993',
        'socket' => 'SSL',
    ],

    'smtp' => [
        'host' => 'smtp.mycompany.com',
        'port' => '587',
        'socket' => 'SSL',
    ],

    'ssl' => [
        'cert' => 'ssl/cert.pem',
        'key' => 'ssl/key.pem',
        'ca' => 'ssl/ca.pem',
    ],
];