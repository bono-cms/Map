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
     * Fetch all maps
     * 
     * @return array
     */
    public function fetchAll()
    {
        $db = $this->db->select('*')
                       ->from(self::getTableName())
                       ->orderBy('id')
                       ->desc();

        return $db->queryAll();
    }
}
