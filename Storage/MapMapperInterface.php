<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Storage;

interface MapMapperInterface
{
    /**
     * Fetch map names and their corresponding id
     * 
     * @return array
     */
    public function fetchList();

    /**
     * Fetch all maps
     * 
     * @return array
     */
    public function fetchAll();
}
