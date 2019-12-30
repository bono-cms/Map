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

use Krystal\Validate\Pattern;
use Krystal\Stdlib\VirtualEntity;
use Cms\Controller\Admin\AbstractController;
use Map\Collection\LanguageCollection;

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
            // Grab current language code
            $code = $this->getService('Cms', 'languageManager')->fetchByCurrentId()->getCode();

            // Append breadcrumbs
            $this->view->getBreadcrumbBag()->addOne('Maps', 'Map:Admin:Map@indexAction')
                                           ->addOne($this->translator->translate('Viewing the "%s" map', $map->getName()));

            return $this->view->render('map/view', array(
                'config' => $this->getModuleService('mapMarkerService')->createConfiguration($map, $code)
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

        $langCol = new LanguageCollection();

        return $this->view->render('map/form', array(
            'map' => $map,
            'markers' => $map->getId() ? $this->getModuleService('mapMarkerService')->fetchAll($map->getId()) : false,
            'mapLanguages' => $langCol->getAll()
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
        $map->setZoom(5)
            ->setHeight(500); // Default

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
     * Returns form validation rules
     * 
     * @return array
     */
    private function getRules()
    {
        return array(
            'name' => new Pattern\Name,
            'height' => new Pattern\Height,
            'lat' => array(
                'required' => true,
                'rules' => array('Latitude')
            ),
            'lng' => array(
                'required' => true,
                'rules' => array('Longitude')
            ),
            'api_key' => array(
                'required' => true,
                'rules' => array(
                    'NotEmpty' => array(
                        'message' => 'Google API key can not be empty'
                    )
                )
            ),
            'style' => array(
                'required' => false,
                'rules' => array('Json')
            )
        );
    }

    /**
     * Saves a map
     * 
     * @return mixed
     */
    public function saveAction()
    {
        // Raw POST data
        $input = $this->request->getAll();

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input['data']['map'],
                'definition' => $this->getRules()
            )
        ));

        if ($formValidator->isValid()) {
            $mapService = $this->getModuleService('mapService');
            $mapService->save($input);

            if ($input['data']['map']['id']) {
                $this->flashBag->set('success', 'The element has been updated successfully');
                return 1;
            } else {

                $this->flashBag->set('success', 'The element has been created successfully');
                return $mapService->getLastId();
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
