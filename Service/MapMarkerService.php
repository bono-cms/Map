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

use Krystal\Security\Filter;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;
use Cms\Service\AbstractManager;
use Map\Storage\MapMarkerMapperInterface;

final class MapMarkerService extends AbstractManager
{
    /**
     * Any compliant map marker mapper
     * 
     * @var \Map\Storage\MapMarkerMapperInterface
     */
    private $mapMarkerMapper;

    /**
     * State initialization
     * 
     * @param \Map\Storage\MapMarkerMapperInterface $mapMarkerMapper
     * @return void
     */
    public function __construct(MapMarkerMapperInterface $mapMarkerMapper)
    {
        $this->mapMarkerMapper = $mapMarkerMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setLangId($row['lang_id'])
               ->setMapId($row['map_id'])
               ->setLat($row['lat'])
               ->setLng($row['lng'])
               ->setPopup($row['popup'], VirtualEntity::FILTER_BOOL)
               ->setDraggable($row['draggable'], VirtualEntity::FILTER_BOOL)
               ->setIcon($row['icon'])
               ->setAnimation($row['animation'])
               ->setDescription($row['description']);

        return $entity;
    }

    /**
     * Creates markers based on a map
     * 
     * @param \Krystal\Stdlib\VirtualEntity $map
     * @return array
     */
    private function createMarkers(VirtualEntity $map)
    {
        // Fetch all attached markers
        $markers = $this->fetchAll($map->getId(), false);

        foreach ($markers as &$marker) {
            // In case we have a global icon and current marker hasn't one
            if ($map->getIcon() && empty($marker['icon'])) {
                // Then override an icon of current marker
                $marker['icon'] = $map->getIcon();
            }
        }

        return $markers;
    }

    /**
     * Creates shared map configuration
     * 
     * @param \Krystal\Stdlib\VirtualEntity $map
     * @param string $code Current language code
     * @return array
     */
    public function createConfiguration(VirtualEntity $map, $code)
    {
        if (!$map->getLanguage()) {
            $map->setLanguage($code);
        }

        // Required parameters for rendering
        return array(
            'static' => $map->getStatic(),
            'routed' => $map->getRouted(),
            'gesture' => $map->getGesture(),
            'clustering' => $map->getClustering(),
            'type' => $map->getType(),
            'key' => $map->getApiKey(),
            'id' => sprintf('map-%s', $map->getId()),
            'lat' => $map->getLat(),
            'lng' => $map->getLng(),
            'zoom' => $map->getZoom(),
            'height' => $map->getHeight(),
            'style' => $map->getStyle(),
            'language' => $map->getLanguage(),
            'markers' => $this->createMarkers($map)
        );
    }

    /**
     * Returns last marker id
     * 
     * @return int
     */
    public function getLastId()
    {
        return $this->mapMarkerMapper->getMaxId();
    }

    /**
     * Delete a marker by its id
     * 
     * @param int $id Marker id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->mapMarkerMapper->deleteByPk($id);
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
        if ($withTranslations == true) {
            return $this->prepareResults($this->mapMarkerMapper->fetchById($id, true));
        } else {
            return $this->prepareResult($this->mapMarkerMapper->fetchById($id, false));
        }
    }

    /**
     * Fetch all markers
     * 
     * @param int $mapId
     * @param boolean $hydrate
     * @return array
     */
    public function fetchAll($mapId, $hydrate = false)
    {
        $rows = $this->mapMarkerMapper->fetchAll($mapId);

        if ($hydrate == true) {
            $rows = $this->prepareResults($rows);
        }

        return $rows;
    }

    /**
     * Count markers by map id
     * 
     * @param int $mapId
     * @return int
     */
    public function hasMarkers($mapId)
    {
        return $this->mapMarkerMapper->countMarkers($mapId) > 0;
    }

    /**
     * Inherit latitude and longitude from a parent map
     * 
     * @param int $id Marker id
     * @return boolean Depending on success
     */
    public function inheritCoordinates($id)
    {
        return $this->mapMarkerMapper->inheritCoordinates($id);
    }

    /**
     * Saves a marker
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function save(array $input)
    {
        return $this->mapMarkerMapper->saveEntity($input['marker'], $input['translation']);
    }
}
