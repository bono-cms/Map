<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Collection;

use Krystal\Stdlib\ArrayCollection;

final class GestureCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    protected $collection = array(
        'auto' => 'Auto',
        'greedy' => 'Always pan',
        'cooperative' => 'Cooperative',
        'none' => 'None'
    );
}
