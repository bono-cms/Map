<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Service;

use Krystal\Application\View\ViewManagerInterface;

final class SiteService
{
    /**
     * View instance
     * 
     * @var \Krystal\Application\View\ViewManagerInterface
     */
    private $view;

    /**
     * Map service instance
     * 
     * @var \Map\Service\MapService
     */
    private $mapService;

    /**
     * Marker service instance
     * 
     * @var \Map\Service\MapMarkerService
     */
    private $mapMarkerService;

    /**
     * Current language code
     * 
     * @var string
     */
    private $code;

    /**
     * State initialization
     * 
     * @param \Map\Service\MapService $mapService
     * @param \Map\Service\MapMarkerService $mapMarkerService
     * @param string $code Current language code
     * @return void
     */
    public function __construct(MapService $mapService, MapMarkerService $mapMarkerService, $code)
    {
        $this->mapService = $mapService;
        $this->mapMarkerService = $mapMarkerService;
        $this->code = $code;
    }

    /**
     * Sets configured view instance
     * 
     * @param \Krystal\Application\View\ViewManagerInterface $view
     * @return void
     */
    public function setView(ViewManagerInterface $view)
    {
        // The view is already configured
        $this->view = $view;
    }

    /**
     * Renders a map
     * 
     * @param int $id Map id to be rendered
     * @return string
     */
    public function renderMap($id)
    {
        $map = $this->mapService->fetchById($id);

        // Make sure right map ID supplied
        if ($map !== false) {
            return $this->view->renderRaw('Map', 'admin', 'map/view', array(
                'config' => $this->mapMarkerService->createConfiguration($map, $this->code)
            ));

        } else {
            return null;
        }
    }
}
