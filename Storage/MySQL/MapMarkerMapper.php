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
            self::column('icon'),
            self::column('animation'),
            self::column('order'),
            self::column('address'),
            MapMarkerTranslationMapper::column('lang_id'),
            MapMarkerTranslationMapper::column('description')
        );
    }

    /**
     * Count markers by map id
     * 
     * @param int $mapId
     * @return int
     */
    public function countMarkers($mapId)
    {
        $db = $this->db->select()
                       ->count($this->getPk())
                       ->from(self::getTableName())
                       ->whereEquals('map_id', $mapId);

        return (int) $db->queryScalar();
    }

    /**
     * Inherit latitude and longitude from a parent map
     * 
     * @param int $id Marker id
     * @return boolean Depending on success
     */
    public function inheritCoordinates($id)
    {
        $db = $this->db->update(self::getTableName())
                       // Map relation
                       ->innerJoin(MapMapper::getTableName(), array(
                            MapMapper::column('id') => self::getRawColumn('map_id')
                       ))
                       ->set(array(
                            self::column('lat') => MapMapper::getRawColumn('lat'),
                            self::column('lng') => MapMapper::getRawColumn('lng')
                       ))
                       ->whereEquals(self::column('id'), $id);

        return (bool) $db->execute(true);
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
                   ->orderBy(self::column('order'))
                   ->desc();

        return $db->queryAll();
    }
}
