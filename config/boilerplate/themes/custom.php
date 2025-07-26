<?php

/**
 * BG : blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan, gray, gray-dark, black
 * Type : dark, light
 * Shadow : 0-4.
 */
return [
    'navbar' => [
        'bg' => 'blue',
        'type' => 'dark',
        'border' => true,
        'user' => [
            'visible' => true,
            'shadow' => 0,
        ],
        'right' => ['backend.nav.notification'],
    ],
    'sidebar' => [
        'type' => 'dark',
        'shadow' => 4,
        'border' => false,
        'compact' => false,
        'links' => [
            'bg' => 'indigo',
            'shadow' => 1,
        ],
        'brand' => [
            'bg' => 'indigo',
            'logo' => [
                'bg' => 'white',
                'icon' => '<img src="/logo/new-logo.png" width="50" height="40">',
                'text' => '<strong>Mars Bangla</strong>',
                'shadow' => 2,
            ],
        ],
        'user' => [
            'visible' => false,
            'shadow' => 2,
        ],
    ],
    'footer' => [
        'visible' => true,
        'vendorname' => 'Mars Bangla',
        'vendorlink' => '',
    ],
    'card' => [
        'outline' => true,
        'default_color' => 'info',
    ],
];
