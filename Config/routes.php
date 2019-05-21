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
    )
);
