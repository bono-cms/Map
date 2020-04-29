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
     * Count markers by map id
     * 
     * @param int $mapId
     * @return int
     */
    public function countMarkers($mapId);

    /**
     * Inherit latitude and longitude from a parent map
     * 
     * @param int $id Marker id
     * @return boolean Depending on success
     */
    public function inheritCoordinates($id);

    /**
     * Fetches map marker by its id
     * 
     * @param int $id Marker id
     * @param boolean $withTranslations Whether to fetch translations
     * @return mixed
     */
    public function fetchById($id, $withTranslations);

    /**
     * Fetch all markers associated with map id
     * 
     * @param int $mapId
     * @return array
     */
    public function fetchAll($mapId);
}
