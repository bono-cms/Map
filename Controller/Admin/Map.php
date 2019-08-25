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
     * Renders a map by its id
     * 
     * @param int $mapId
     * @return string
     */
    public function viewAction($mapId)
    {
        $map = $this->getModuleService('mapService')->fetchById($mapId);

        // Make sure right supplied
        if ($map !== false) {
            // Append breadcrumbs
            $this->view->getBreadcrumbBag()->addOne('Maps', 'Map:Admin:Map@indexAction')
                                           ->addOne('View a map');

            return $this->view->render('map/view', array(
                'config' => array(
                    'key' => $map->getApiKey(),
                    'id' => sprintf('map-%s', $map->getId()),
                    'lat' => $map->getLat(),
                    'lng' => $map->getLng(),
                    'zoom' => $map->getZoom(),
                    'markers' => $this->getModuleService('mapMarkerService')->fetchAll($mapId, false)
                )
            ));
        } else {
            return false;
        }
    }

    /**
     * Renders the form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $map
     * @param string $title Page title
     * @return string
     */
    private function createForm(VirtualEntity $map, $title)
    {
        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('Maps', 'Map:Admin:Map@indexAction')
                                       ->addOne($title);

        return $this->view->render('map/form', array(
            'map' => $map,
            'markers' => $map->getId() ? $this->getModuleService('mapMarkerService')->fetchAll($map->getId()) : false
        ));
    }

    /**
     * Renders collection of maps
     * 
     * @return string
     */
    public function indexAction()
    {
        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('Maps', 'Map:Admin:Map@indexAction');

        return $this->view->render('map/index', array(
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

        return $this->createForm($map, 'Add new map');
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
            return $this->createForm($map, $this->translator->translate('Edit the map "%s"', $map->getName()));
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

        $this->flashBag->set('success', 'Selected element has been removed successfully');
        return 1;
    }

    /**
     * Saves a map
     * 
     * @return mixed
     */
    public function saveAction()
    {
        // Raw POST data
        $input = $this->request->getPost('map');

        $mapService = $this->getModuleService('mapService');
        $mapService->save($input);

        if ($input['id']) {

            $this->flashBag->set('success', 'The element has been updated successfully');
            return 1;
        } else {

            $this->flashBag->set('success', 'The element has been created successfully');
            return $mapService->getLastId();
        }
    }
}
