<?php

/**
 * This file is part of the Bono CMS
 *
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Driver;

interface DriverInterface
{
    /**
     * Returns unique driver identifier, e.g. "google"
     *
     * @return string
     */
    public function getId();

    /**
     * Returns human-readable driver name shown in admin dropdown
     *
     * @return string
     */
    public function getName();

    /**
     * Builds the service URL for the provider's JS SDK
     *
     * @param string $apiKey
     * @param string|null $language
     * @param string|null $libraries Comma-separated libraries
     * @return string
     */
    public function getServiceUrl($apiKey, $language = null, $libraries = null);

    /**
     * Returns asset paths to load for this driver
     *
     * @return array
     */
    public function getAssets();

    /**
     * Returns extra asset URLs required by the given configuration
     * (e.g. clustering library). Full URLs or '@Module/...' paths.
     *
     * @param array $config Normalized map configuration
     * @return array
     */
    public function getExtraAssets(array $config);

    /**
     * Returns available map types for this driver
     *
     * @return array
     */
    public function getMapTypes();

    /**
     * Returns available gesture-handling modes for this driver
     *
     * @return array
     */
    public function getGestures();
}
