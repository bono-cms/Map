
CREATE TABLE `bono_module_map_maps` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `lat` varchar(255) NOT NULL COMMENT 'Initial latitude',
    `lng` varchar(255) NOT NULL COMMENT 'Initial longtitude',
    `zoom` INT NOT NULL COMMENT 'Initial zoom level'
);
