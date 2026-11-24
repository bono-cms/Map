<?php

/**
 * This file is part of the Bono CMS
 *
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Driver;

final class GoogleDriver implements DriverInterface
{
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return 'google';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'Google Maps';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceUrl($apiKey, $language = null, $libraries = null)
    {
        // Consider empty string as NULL
        if (empty($language)) {
            $language = null;
        }

        return 'https://maps.googleapis.com/maps/api/js?' . http_build_query([
            'key' => $apiKey,
            'language' => $language,
            'libraries' => $libraries
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getAssets()
    {
        return [
            '@Map/google.handler.js',
            '@Map/google.maps.js'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getExtraAssets(array $config)
    {
        $assets = [];

        // Clustering requires the marker clusterer library
        if (!empty($config['clustering'])) {
            $assets[] = 'https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js';
        }

        return $assets;
    }

    /**
     * {@inheritDoc}
     */
    public function getMapTypes()
    {
        return [
            'roadmap' => 'Road map view (Default)',
            'satellite' => 'Satellite images',
            'hybrid' => 'Normal and satellite views',
            'terrain' => 'Map based on terrain information'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getGestures()
    {
        return [
            'auto' => 'Auto',
            'greedy' => 'Always pan',
            'cooperative' => 'Cooperative',
            'none' => 'None'
        ];
    }
}