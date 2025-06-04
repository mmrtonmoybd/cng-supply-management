<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => false,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:pwa-update-manifest
    */

    'manifest' => [
        'name' => 'Mars Bangla Fuel Solution',
        'short_name' => 'Mars Bangla',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'description' => 'Reliable and efficient fuel delivery, storage, and management services across Bangladesh.',
        'theme_color' => '#004e92',
        'icons' => [
            [
                'src' => 'logo/logo512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

];
