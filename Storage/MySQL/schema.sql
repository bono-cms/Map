
CREATE TABLE `bono_module_map_maps` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `lat` varchar(255) NOT NULL COMMENT 'Initial latitude',
    `lng` varchar(255) NOT NULL COMMENT 'Initial longtitude',
    `zoom` INT NOT NULL COMMENT 'Initial zoom level',
    `api_key` varchar(255) NOT NULL COMMENT 'Personal API Key'
);

CREATE TABLE `bono_module_map_markers` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `map_id` INT NOT NULL COMMENT 'Attached map ID',
    `lat` varchar(255) NOT NULL COMMENT 'Marker latitude',
    `lng` varchar(255) NOT NULL COMMENT 'Marker longtitude',
    `draggable` BOOLEAN NOT NULL COMMENT 'Whether this marker is draggable',
    `description` TEXT NOT NULL COMMENT 'Content for InfoWindow'

    FOREIGN KEY (map_id) REFERENCES bono_module_map_maps(id) ON DELETE CASCADE
);