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
use Map\Storage\MapMapperInterface;

final class MapMapper extends AbstractMapper implements MapMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_map_maps');
    }

    /**
     * Fetch map names and their corresponding id
     * 
     * @return array
     */
    public function fetchList()
    {
        $db = $this->db->select(array('id', 'name'))
                       ->from(self::getTableName())
                       ->orderBy('id')
                       ->desc();

        return $db->queryAll();
    }

    /**
     * Fetch all maps
     * 
     * @return array
     */
    public function fetchAll()
    {
        // To be selected and grouped
        $columns = array(
            self::column('id'),
            self::column('lat'),
            self::column('lng'),
            self::column('zoom'),
            self::column('api_key'),
            self::column('name'),
            self::column('height'),
            self::column('style'),
            self::column('language'),
            self::column('icon'),
            self::column('clustering'),
            self::column('type'),
            self::column('gesture'),
            self::column('routed'),
            self::column('static')
        );

        $db = $this->db->select($columns)
                       ->count(MapMarkerMapper::column('id'), 'marker_count')
                       ->from(self::getTableName())
                       // Marker relation
                       ->leftJoin(MapMarkerMapper::getTableName(), array(
                            MapMarkerMapper::column('map_id') => self::getRawColumn('id')
                       ))
                       ->groupBy($columns)
                       ->orderBy(self::column('id'))
                       ->desc();

        return $db->queryAll();
    }
}
