<?php

return array(
    '/%s/module/map' => array(
        'controller' => 'Admin:Map@indexAction'
    ),

    '/%s/module/map/add' => array(
        'controller' => 'Admin:Map@addAction'
    ),

    '/%s/module/map/edit/(:var)' => array(
        'controller' => 'Admin:Map@editAction'
    ),

    '/%s/module/map/delete/(:var)' => array(
        'controller' => 'Admin:Map@deleteAction'
    ),

    '/%s/module/map/save' => array(
        'controller' => 'Admin:Map@saveAction'
    ),
    
    // Marker
    '/%s/module/map-marker/add/(:var)' => array(
        'controller' => 'Admin:MapMarker@addAction'
    ),

    '/%s/module/map-marker/edit/(:var)' => array(
        'controller' => 'Admin:MapMarker@editAction'
    ),

    '/%s/module/map-marker/delete/(:var)' => array(
        'controller' => 'Admin:MapMarker@deleteAction'
    ),

    '/%s/module/map-marker/save' => array(
        'controller' => 'Admin:MapMarker@saveAction'
    )
);
