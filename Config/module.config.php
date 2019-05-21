<?php

/**
 * Module configuration container
 */

return array(
    'name' => 'Map',
    'description' => 'Map module lets you manage maps on your site',
    'menu' => array(
        'name' => 'Maps',
        'icon' => 'fas fa-map-marked-alt',
        'items' => array(
            array(
                'route' => 'Map:Admin:Map@indexAction',
                'name' => 'View all maps'
            )
        )
    )
);