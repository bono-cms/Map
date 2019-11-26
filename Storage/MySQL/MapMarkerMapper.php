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
     * {@inheritDoc}
     */
    public static function getTranslationTable()
    {
        return MapMarkerTranslationMapper::getTableName();
    }

    /**
     * Returns shared columns to be selected
     * 
     * @return array
     */
    private function getColumns()
    {
        return array(
            self::column('id'),
            self::column('map_id'),
            self::column('lat'),
            self::column('lng'),
            self::column('draggable'),
            self::column('popup'),
            MapMarkerTranslationMapper::column('lang_id'),
            MapMarkerTranslationMapper::column('description')
        );
    }

    /**
     * Fetches map marker by its id
     * 
     * @param int $id Marker id
     * @param boolean $withTranslations Whether to fetch translations
     * @return mixed
     */
    public function fetchById($id, $withTranslations)
    {
        return $this->findEntity($this->getColumns(), $id, $withTranslations);
    }

    /**
     * Fetch all markers associated with map id
     * 
     * @param int $mapId
     * @return array
     */
    public function fetchAll($mapId)
    {
        $db = $this->createEntitySelect($this->getColumns())
                   ->whereEquals(MapMarkerTranslationMapper::column('lang_id'), $this->getLangId())
                   ->andWhereEquals(self::column('map_id'), $mapId)
                   ->orderBy(self::column('id'))
                   ->desc();

        return $db->queryAll();
    }
}
