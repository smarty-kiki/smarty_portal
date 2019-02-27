# up
CREATE TABLE `url_permission_tag` (
    `id` bigint(20) NOT NULL,
    `version` int(11) NOT NULL,
    `create_time` datetime DEFAULT NULL,
    `update_time` datetime DEFAULT NULL,
    `delete_time` datetime DEFAULT NULL,
    `permission_tag_id` bigint(20) NOT NULL,
    `url_id` bigint(20) NOT NULL,
    KEY `fk_permission_tag_idx` (`permission_tag_id`, `delete_time`),
    KEY `fk_url_idx` (`url_id`, `delete_time`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# down
drop table `url_permission_tag`;
