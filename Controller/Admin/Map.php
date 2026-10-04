<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Controller\Admin;

use Krystal\Stdlib\VirtualEntity;
use Cms\Controller\Admin\AbstractController;
use Map\Collection\LanguageCollection;
use Map\Collection\MapTypeCollection;
use Map\Collection\GestureCollection;

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

            return $this->view->render('map/view', [
                'config' => $this->getModuleService('mapMarkerService')->createConfiguration($map, $code)
            ]);

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
        $typeCol = new MapTypeCollection();
        $gstCol = new GestureCollection();

        return $this->view->render('map/form', [
            'map' => $map,
            'markers' => $map->getId() ? $this->getModuleService('mapMarkerService')->fetchAll($map->getId()) : false,
            'mapLanguages' => $langCol->getAll(),
            'mapTypes' => $typeCol->getAll(),
            'mapGestures' => $gstCol->getAll()
        ]);
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

        return $this->view->render('map/index', [
            'maps' => $this->getModuleService('mapService')->fetchAll()
        ]);
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
        return $this->json([
            'refresh' => true
        ]);
    }

    /**
     * Saves a map
     * 
     * @return mixed
     */
    public function saveAction()
    {
        $validator = $this->createValidation();

        $validator->field('map.name')
                  ->required();

        $validator->field('map.height')
                  ->required()
                  ->addRule('integer');

        $validator->field('map.lat')
                  ->required()
                  ->addRule('latitude');

        $validator->field('map.lng')
                  ->required()
                  ->addRule('longitude');

        $validator->field('map.api_key')
                  ->required();

        $validator->field('map.zoom')
                  ->required();

        $validator->field('map.style')
                  ->addRule('json');

        if ($validator->isPassed()) {
            // Raw POST data
            $input = $this->request->getAll();

            $mapService = $this->getModuleService('mapService');
            $mapService->save($input);

            if ($input['data']['map']['id']) {
                $this->flashBag->set('success', 'The element has been updated successfully');
                return $this->json([
                    'refresh' => true
                ]);
            } else {
                $this->flashBag->set('success', 'The element has been created successfully');
                return $this->json([
                    'redirect' => $this->createUrl('Map:Admin:Map@editAction', [$mapService->getLastId()]),
                ]);
            }

        } else {
            return $this->json([
                'errors' => $validator->getErrors()
            ]);
        }
    }
}