<?php

/**
 * This file is part of the Bono CMS
 *
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Driver;

use InvalidArgumentException;

final class DriverRegistry
{
    /**
     * Registered driver class map
     *
     * @var array
     */
    private static $drivers = [
        'google' => GoogleDriver::class,
        'osm' => OsmDriver::class
    ];

    /**
     * Returns a driver instance by its identifier
     *
     * @param string $id Driver identifier
     * @return \Map\Driver\DriverInterface
     * @throws \InvalidArgumentException When driver is unknown
     */
    public static function get($id)
    {
        if (!isset(self::$drivers[$id])) {
            throw new InvalidArgumentException(sprintf('Unknown map driver "%s"', $id));
        }

        $className = self::$drivers[$id];
        return new $className();
    }

    /**
     * Returns all registered drivers as identifier => name map
     *
     * @return array
     */
    public static function getAll()
    {
        $result = [];

        foreach (self::$drivers as $id => $className) {
            $driver = new $className();
            $result[$id] = $driver->getName();
        }

        return $result;
    }
}