<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Controller\Admin;

use Krystal\Stdlib\VirtualEntity;
use Cms\Controller\Admin\AbstractController;

final class Map extends AbstractController
{
    /**
     * Renders the form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $map
     * @return string
     */
    private function createForm(VirtualEntity $map)
    {
        // Append breadcrumbs
        $this->getBreadcrumbBag()->addOne('Maps', 'Map:Admin:Map@indexAction')
                                 ->addOne($map->getId() ? 'Update map' : 'Add new map');

        return $this->view->render('form', array(
            'map' => $map
        ));
    }

    /**
     * Renders collection of maps
     * 
     * @return string
     */
    public function indexAction()
    {
        return $this->view->render('index', array(
            'maps' => $this->getModuleService('mapService')->fetchAll()
        ));
    }

    /**
     * Renders map form
     * 
     * @return string
     */
    public function addAction()
    {
        $map = new VirtualEntity();
        $map->setZoom(5); // Default

        return $this->createForm($map);
    }

    /**
     * Renders edit form
     * 
     * @param int $id
     * @return string
     */
    public function editAction($id)
    {
        $map = $this->getModuleService('mapService')->fetchById($id);

        if ($map !== false) {
            return $this->createForm($map);
        } else {
            return false;
        }
    }

    /**
     * Deletes a map by its id
     * 
     * @param int $id
     * @return mixed
     */
    public function deleteAction($id)
    {
        $this->getModuleService('mapService')->deleteById($id);
        return 1;
    }

    /**
     * Saves a map
     * 
     * @return mixed
     */
    public function saveAction()
    {
        $input = $this->request->getPost('map');

        $this->getModuleService('mapService')->save($input);

        return 1;
    }
}
