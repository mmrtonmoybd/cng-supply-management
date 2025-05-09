<?php

$theme = include __DIR__.'/themes/red.php';

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left'  => [],
        'right' => [''],
    ],
    'favicon'    => null,       // Favicon url
    'fullscreen' => true,      // Fullscreen switch
    'darkmode'   => true,       // Dark mode switch
    'minify'     => true,       // Minify inline JS / CSS when using boilerplate::minify component
];

return $theme;
