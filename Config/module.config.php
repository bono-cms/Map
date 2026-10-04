<?php

/**
 * Module configuration container
 */

return [
    'name' => 'Map',
    'description' => 'Map module lets you manage maps on your site',
    'menu' => [
        'name' => 'Maps',
        'icon' => 'fas fa-map-marked-alt',
        'items' => [
            [
                'route' => 'Map:Admin:Map@indexAction',
                'name' => 'View all maps'
            ]
        ]
    ]
];