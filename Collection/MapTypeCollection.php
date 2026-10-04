<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Collection;

use Krystal\Stdlib\ArrayCollection;

final class MapTypeCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    protected $collection = [
        'roadmap' => 'Road map view (Default)',
        'satellite' => 'Satellite images',
        'hybrid' => 'Normal and satellite views',
        'terrain' => 'Map based on terrain information'
    ];
}