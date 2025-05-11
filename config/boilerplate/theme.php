<?php

$theme = include __DIR__.'/themes/red.php';

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left' => [],
        'right' => [''],
    ],
    'favicon' => null,       // Favicon url
    'fullscreen' => false,      // Fullscreen switch
    'darkmode' => false,       // Dark mode switch
    'minify' => false,       // Minify inline JS / CSS when using boilerplate::minify component
];

return $theme;
