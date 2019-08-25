<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Storage;

interface MapMarkerMapperInterface
{
    /**
     * Fetch all markers associated with map id
     * 
     * @param int $mapId
     * @return array
     */
    public function fetchAll($mapId);
}
