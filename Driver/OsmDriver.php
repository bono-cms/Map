<?php

/**
 * This file is part of the Bono CMS
 *
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Driver;

final class OsmDriver implements DriverInterface
{
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return 'osm';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'OpenStreetMap';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceUrl($apiKey, $language = null, $libraries = null)
    {
        // OpenStreetMap does not require an API key.
        // Return the Leaflet JS library URL.
        return 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    }

    /**
     * {@inheritDoc}
     */
    public function getScripts()
    {
        return [
            '@Map/osm.maps.js'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getStyles()
    {
        return [
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getExtraScripts(array $config)
    {
        $scripts = [];

        // Clustering requires the Leaflet.markercluster plugin
        if (!empty($config['clustering'])) {
            $scripts[] = 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js';
        }

        return $scripts;
    }

    /**
     * {@inheritDoc}
     */
    public function getExtraStyles(array $config)
    {
        $styles = [];

        // Clustering requires the Leaflet.markercluster plugin styles
        if (!empty($config['clustering'])) {
            $styles[] = 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css';
            $styles[] = 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css';
        }

        return $styles;
    }

    /**
     * {@inheritDoc}
     */
    public function getMapTypes()
    {
        // Leaflet is provider-agnostic. The "type" here controls
        // the tile URL template. OSM standard is the default.
        return [
            'osm' => 'OpenStreetMap Standard'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getGestures()
    {
        // Leaflet's gesture handling is controlled by its own options.
        // We map the generic gesture values to Leaflet behaviors.
        return [
            'auto' => 'Auto',
            'none' => 'None'
        ];
    }
}