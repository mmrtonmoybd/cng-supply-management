<?php

return [
    // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'prefix' => '',

    // Backend domain if different as current domain. Ex: "admin.mydomain.tld"
    'domain' => '',

    // Redirect to this route after login
    'redirectTo' => 'boilerplate.dashboard',

    // Activating daily logs and showing log viewer
    'logs' => true,

    // When set to true, allows admins to view the site as a user of their choice
    'allowImpersonate' => false,

    // If true, the session will be kept alive and the user must log out
    'keepalive' => false,

    // Allows to generate text with ChatGPT in TinyMCE
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'model' => 'gpt-3.5-turbo',
        'organization' => env('OPENAI_API_ORGANIZATION'),
    ],

    // Progressive Web App configuration
    'pwa' => [
        'enabled' => true,
        'name' => 'Mars Bangla Fuel Solution ltd.',
        'short_name' => 'Mars Bangla',
        'description' => 'Reliable and efficient fuel delivery, storage, and management services across Bangladesh.',
        'theme_color' => '#007bff',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'orientation' => 'portrait-primary',
        'apple_touch_icon' => 'logo/logo180.png',
        'icons' => [
            [
                'src' => 'logo/logo512.svg',
                'sizes' => 'any',
                'type' => 'image/svg+xml',
            ],

            [
                'src' => 'logo/logo192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => 'logo/logo512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],

        ],
    ],
];
