# up
CREATE TABLE `menu` (
    `id` bigint(20) NOT NULL,
    `version` int(11) NOT NULL,
    `create_time` datetime DEFAULT NULL,
    `update_time` datetime DEFAULT NULL,
    `delete_time` datetime DEFAULT NULL,
    `name` varchar(45) NOT NULL,
    `level` int(11) NOT NULL,
    `system_id` bigint(20) NOT NULL,
    `menu_id` bigint(20) NOT NULL,
    KEY `fk_system_idx` (`system_id`, `delete_time`),
    KEY `fk_menu_idx` (`menu_id`, `delete_time`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# down
drop table `menu`;
