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

use Map\Storage\MapMapperInterface;
use Krystal\Stdlib\VirtualEntity;
use Cms\Service\AbstractManager;

final class MapService extends AbstractManager
{
    /**
     * Any compliant map mapper
     * 
     * @var \Map\Storage\MapMapperInterface
     */
    private $mapMapper;

    /**
     * State initialization
     * 
     * @param \Map\Storage\MapMapperInterface $mapMapper
     * @return void
     */
    public function __construct(MapMapperInterface $mapMapper)
    {
        $this->mapMapper = $mapMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setLat($row['lat'])
               ->setLng($row['lng'])
               ->setZoom($row['zoom'])
               ->setApiKey($row['api_key']);

        return $entity;
    }

    /**
     * Fetches map by its id
     * 
     * @param int $id Map id
     * @return mixed
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->mapMapper->findByPk($id));
    }

    /**
     * Fetch all maps
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->prepareResults($this->mapMapper->fetchAll());
    }

    /**
     * Deletes map by its id
     * 
     * @param int $id Map id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->mapMapper->deleteByPk($id);
    }

    /**
     * Saves a map
     * 
     * @param array $input
     * @return boolean
     */
    public function save(array $input)
    {
        return $this->mapMapper->persist($input);
    }

    /**
     * Returns last map id
     * 
     * @return int
     */
    public function getLastId()
    {
        return $this->mapMapper->getMaxId();
    }
}
