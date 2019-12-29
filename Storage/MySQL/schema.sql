
CREATE TABLE `bono_module_map_maps` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `lat` varchar(255) NOT NULL COMMENT 'Initial latitude',
    `lng` varchar(255) NOT NULL COMMENT 'Initial longtitude',
    `zoom` INT NOT NULL COMMENT 'Initial zoom level',
    `api_key` varchar(255) NOT NULL COMMENT 'Personal API Key',
    `name` varchar(255) NOT NULL COMMENT 'Map name',
    `height` INT NOT NULL COMMENT 'Map height',
    `style` TEXT NOT NULL COMMENT 'Custom style JS-Array',
    `language` varchar(10) NOT NULL COMMENT 'Map language',
    `icon` varchar(255) NOT NULL COMMENT 'Shared icon for all markers'
);

/* Markers */
CREATE TABLE `bono_module_map_markers` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `map_id` INT NOT NULL COMMENT 'Attached map ID',
    `lat` varchar(255) NOT NULL COMMENT 'Marker latitude',
    `lng` varchar(255) NOT NULL COMMENT 'Marker longtitude',
    `draggable` BOOLEAN NOT NULL COMMENT 'Whether this marker is draggable',
    `popup` BOOLEAN NOT NULL COMMENT 'Whether info window should be opened automatically',
    `icon` varchar(255) NOT NULL COMMENT 'Optional custom map icon',

    FOREIGN KEY (map_id) REFERENCES bono_module_map_maps(id) ON DELETE CASCADE
);

CREATE TABLE `bono_module_map_markers_translations` (
    `id` INT NOT NULL,
    `lang_id` INT NOT NULL COMMENT 'Language identificator',
    `description` TEXT NOT NULL COMMENT 'Content for InfoWindow',

    FOREIGN KEY (id) REFERENCES bono_module_map_markers(id) ON DELETE CASCADE,
    FOREIGN KEY (lang_id) REFERENCES bono_module_cms_languages(id) ON DELETE CASCADE
);
