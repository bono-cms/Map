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

final class MapMarker extends AbstractController
{
    /**
     * Create shared form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $marker
     * @return string
     */
    private function createForm(VirtualEntity $marker)
    {
        // Load view plugins
        $this->view->getPluginBag()->load($this->getWysiwygPluginName());

        // Append breadcrumbs
        $this->view->getBreadcrumbBag()->addOne('Maps', $this->createUrl('Map:Admin:Map@indexAction'))
                                       ->addOne('Edit the map', $this->createUrl('Map:Admin:Map@editAction', array($marker->getMapId())))
                                       ->addOne($marker->getId() ? 'Update marker' : 'Add new marker');

        return $this->view->render('marker/form', array(
            'marker' => $marker
        ));
    }

    /**
     * Renders adding form
     * 
     * @param int $mapId Map id
     * @return mixed
     */
    public function addAction($mapId)
    {
        $marker = new VirtualEntity();
        $marker->setMapId($mapId);

        return $this->createForm($marker);
    }

    /**
     * Renders edit form
     * 
     * @param int $id $id Marker id
     * @return string
     */
    public function editAction($id)
    {
        $marker = $this->getModuleService('mapMarkerService')->fetchById($id);

        if ($marker !== false) {
            return $this->createForm($marker);
        } else {
            return false;
        }
    }

    /**
     * Deletes a marker by its id
     * 
     * @param int $id Marker id
     * @return mixed
     */
    public function deleteAction($id)
    {
        $this->getModuleService('mapMarkerService')->deleteById($id);

        $this->flashBag->set('success', 'Selected element has been removed successfully');
        return 1;
    }

    /**
     * Persists a marker
     * 
     * @return mixed
     */
    public function saveAction()
    {
        $input = $this->request->getPost('marker');

        $mapMarkerService = $this->getModuleService('mapMarkerService');
        $mapMarkerService->save($input);

        if ($input['id']) {
            $this->flashBag->set('success', 'The element has been updated successfully');
            return 1;
        } else {
            $this->flashBag->set('success', 'The element has been created successfully');
            return $mapMarkerService->getLastId();
        }
    }
}