<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map;

use Cms\AbstractCmsModule;
use Map\Service\MapService;
use Map\Service\MapMarkerService;
use Map\Service\SiteService;

final class Module extends AbstractCmsModule
{
    /**
     * {@inheritDoc}
     */
    public function getServiceProviders()
    {
        $mapService = new MapService($this->getMapper('\Map\Storage\MySQL\MapMapper'), $this->getAppConfig());
        $mapMarkerService = new MapMarkerService($this->getMapper('\Map\Storage\MySQL\MapMarkerMapper'));

        return array(
            'siteService' => new SiteService($mapService, $mapMarkerService),
            'mapService' => $mapService,
            'mapMarkerService' => $mapMarkerService
        );
    }
}
