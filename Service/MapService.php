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

use RuntimeException;
use Map\Storage\MapMapperInterface;
use Cms\Service\AbstractManager;
use Krystal\Application\AppConfigInterface;
use Krystal\Http\FileTransfer\FileUploader;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Filesystem\FileManager;
use Map\Module;

final class MapService extends AbstractManager
{
    /* Path for shared marker icons */
    const ICON_PATH = '/data/uploads/module/map';

    /**
     * Any compliant map mapper
     * 
     * @var \Map\Storage\MapMapperInterface
     */
    private $mapMapper;

    /**
     * App configuration object
     * 
     * @var \Krystal\Application\AppConfigInterface
     */
    private $appConfig;

    /**
     * State initialization
     * 
     * @param \Map\Storage\MapMapperInterface $mapMapper
     * @param \Krystal\Application\AppConfigInterface $appConfig
     * @return void
     */
    public function __construct(MapMapperInterface $mapMapper, AppConfigInterface $appConfig)
    {
        $this->mapMapper = $mapMapper;
        $this->appConfig = $appConfig;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity(false);
        $entity->setId($row['id'])
               ->setLat($row['lat'])
               ->setLng($row['lng'])
               ->setZoom($row['zoom'])
               ->setApiKey($row['api_key'])
               ->setName($row['name'])
               ->setHeight($row['height'])
               ->setStyle($row['style'])
               ->setLanguage($row['language'])
               ->setIcon($row['icon'])
               ->setClustering($row['clustering'])
               ->setType($row['type'])
               ->setGesture($row['gesture']);

        if (isset($row['marker_count'])) {
            $entity->setMarkerCount($row['marker_count']);
        }

        return $entity;
    }

    /**
     * Creates service Google API from API key
     * 
     * @param string $key API key provided by Google
     * @param string $language Optional language
     * @return string
     */
    public static function createServiceUrl($key, $language = null)
    {
        $base = 'https://maps.googleapis.com/maps/api/js';

        // Consider empty string as NULL
        if (empty($language)) {
            $language = null;
        }

        return $base . '?' . http_build_query(array('key' => $key, 'language' => $language));
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
        return $this->mapMapper->deleteByPk($id) && $this->removeIcon($id);
    }

    /**
     * Removed icon by map id
     * 
     * @param int $id Map id
     * @return boolean
     */
    private function removeIcon($id)
    {
        $mapDir = $this->appConfig->getRootDir() . self::ICON_PATH . '/' . $id;

        if (is_dir($mapDir)) {
            return FileManager::rmdir($mapDir);
        } else {
            return false;
        }
    }

    /**
     * Saves a map
     * 
     * @param array $input Raw input data
     * @return boolean Depending on success
     */
    public function save(array $input)
    {
        // Map data
        $data = $input['data']['map'];

        // Icon file. Check whether uploaded
        $icon = isset($input['files']['map']['icon']) ? $input['files']['map']['icon'] : false;
        $removeIcon = isset($input['data']['purge']);
        $id = is_numeric($data['id']) ? $data['id'] : $this->getLastId() + 1;

        // If removing icon is required
        if ($removeIcon) {
            $data['icon'] = '';
            $this->removeIcon($id);
        }

        // If an icon is provided, then upload it
        if ($icon !== false) {
            // Target destination
            $destination = sprintf('%s/%s', $this->appConfig->getRootDir() . self::ICON_PATH, $id);

            // Current icon value
            $current = $this->appConfig->getRootDir() . '/' .$data['icon'];

            // Remove previous if available
            try {
                FileManager::rmfile($current);
            } catch (RuntimeException $e) {
            }

            // Upload
            $uploader = new FileUploader();

            if ($uploader->upload($destination, array($icon))) {
                $data['icon'] = self::ICON_PATH . '/' . $id  . '/' . $icon->getUniqueName();
            }
        }

        return $this->mapMapper->persist($data);
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
