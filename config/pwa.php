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
        'name' => 'Mars Bangla',
        'short_name' => 'MarsBangla',
        'background_color' => '#f8f9fa',
        'display' => 'standalone',
        'description' => 'Mars Bangla Fuel Solution Ltd is a leading fuel solution provider in Bangladesh, offering a wide range of services including fuel delivery, storage, and management. Our mission is to provide reliable and efficient fuel solutions to our customers while ensuring safety and sustainability.',
        'theme_color' => '#f8f9fa',
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
