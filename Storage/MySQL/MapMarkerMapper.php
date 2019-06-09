<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Map\Storage\MapMarkerMapperInterface;

final class MapMarkerMapper extends AbstractMapper implements MapMarkerMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_map_markers');
    }

    /**
     * Fetch all markers associated with map id
     * 
     * @param int $mapId
     * @param boolean $all Whether to fetch all columns or lat, lng only
     * @return array
     */
    public function fetchAll($mapId, $all = true)
    {
        $columns = $all === true ? '*' : array('lat', 'lng');

        $db = $this->db->select($columns)
                       ->from(self::getTableName())
                       ->whereEquals('map_id', $mapId)
                       ->orderBy('id')
                       ->desc();

        return $db->queryAll();
    }
}
