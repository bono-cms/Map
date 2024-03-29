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
use Krystal\Validate\Pattern;
use Cms\Controller\Admin\AbstractController;
use Map\Service\MapService;

final class MapMarker extends AbstractController
{
    /**
     * Inherit marker coordinates from a parent map
     * 
     * @param int $id Marker id
     * @return boolean
     */
    public function inheritAction($id)
    {
        if ($this->getModuleService('mapMarkerService')->inheritCoordinates($id)) {
            $this->flashBag->set('success', 'Coordinates of selected marker have been inherited successfully!');
        } else {
            $this->flashBag->set('success', 'An error occurred during inheritance');
        }

        return $this->response->back();
    }

    /**
     * Create shared form
     * 
     * @param \Krystal\Stdlib\VirtualEntity|array $marker
     * @param string $title Page title
     * @return string|boolean
     */
    private function createForm($marker, $title)
    {
        $entity = is_array($marker) ? $marker[0] : $marker;

        $mapId = $entity->getMapId();
        $map = $this->getModuleService('mapService')->fetchById($mapId);

        if ($map !== false) {
            // Load view plugins
            $this->view->getPluginBag()->load($this->getWysiwygPluginName())
                                       ->appendScripts(array(
                                            MapService::createServiceUrl($map->getApiKey(), $this->appConfig->getLanguage(), 'places'),
                                            '@Map/google.handler.js'
                                       ));

            // Append breadcrumbs
            $this->view->getBreadcrumbBag()->addOne('Maps', $this->createUrl('Map:Admin:Map@indexAction'))
                                           ->addOne($this->translator->translate('Edit the map "%s"', $map->getName()), $this->createUrl('Map:Admin:Map@editAction', array($mapId)))
                                           ->addOne($title);

            return $this->view->render('marker/form', array(
                'marker' => $marker
            ));
        } else {
            return false;
        }
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

        // If this is the first marker, then inherit its coordinates from the parent map
        if (!$this->getModuleService('mapMarkerService')->hasMarkers($mapId)) {
            $map = $this->getModuleService('mapService')->fetchById($mapId);

            $marker->setLat($map->getLat())
                   ->setLng($map->getLng());
        }

        return $this->createForm($marker, 'Add new marker');
    }

    /**
     * Renders edit form
     * 
     * @param int $id $id Marker id
     * @return string
     */
    public function editAction($id)
    {
        $marker = $this->getModuleService('mapMarkerService')->fetchById($id, true);

        if ($marker !== false) {
            return $this->createForm($marker, $this->translator->translate('Update marker #%s', $id));
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
        $input = $this->request->getPost();

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input['marker'],
                'definition' => array(
                    'lat' => array(
                        'required' => true,
                        'rules' => array(
                            'Latitude'
                        )
                    ),
                    'lng' => array(
                        'required' => true,
                        'rules' => array(
                            'Longitude'
                        )
                    ),
                    'icon' => new Pattern\Url
                )
            )
        ));

        if ($formValidator->isValid()) {
            $mapMarkerService = $this->getModuleService('mapMarkerService');
            $mapMarkerService->save($input);

            if ($input['marker']['id']) {
                $this->flashBag->set('success', 'The element has been updated successfully');
                return 1;
            } else {
                $this->flashBag->set('success', 'The element has been created successfully');
                return $mapMarkerService->getLastId();
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}