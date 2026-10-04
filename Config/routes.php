<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return [
    '/%s/module/map' => [
        'controller' => 'Admin:Map@indexAction'
    ],

    '/%s/module/map/view/(:var)' => [
        'controller' => 'Admin:Map@viewAction'
    ],

    '/%s/module/map/add' => [
        'controller' => 'Admin:Map@addAction'
    ],

    '/%s/module/map/edit/(:var)' => [
        'controller' => 'Admin:Map@editAction'
    ],

    '/%s/module/map/delete/(:var)' => [
        'controller' => 'Admin:Map@deleteAction'
    ],

    '/%s/module/map/save' => [
        'controller' => 'Admin:Map@saveAction'
    ],
    
    // Marker
    '/%s/module/map-marker/inherit/(:var)' => [
        'controller' => 'Admin:MapMarker@inheritAction'
    ],

    '/%s/module/map-marker/add/(:var)' => [
        'controller' => 'Admin:MapMarker@addAction'
    ],

    '/%s/module/map-marker/edit/(:var)' => [
        'controller' => 'Admin:MapMarker@editAction'
    ],

    '/%s/module/map-marker/delete/(:var)' => [
        'controller' => 'Admin:MapMarker@deleteAction'
    ],

    '/%s/module/map-marker/save' => [
        'controller' => 'Admin:MapMarker@saveAction'
    ]
];