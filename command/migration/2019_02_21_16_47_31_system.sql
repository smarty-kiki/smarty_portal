# up
CREATE TABLE `system` (
    `id` bigint(20) NOT NULL,
    `version` int(11) NOT NULL,
    `create_time` datetime DEFAULT NULL,
    `update_time` datetime DEFAULT NULL,
    `delete_time` datetime DEFAULT NULL,
    `name` varchar(45) NOT NULL,
    `api_authorized_token` varchar(45) NOT NULL,
    `api_authorized_ip` varchar(45) NOT NULL,
    `account_id` bigint(20) NOT NULL,
    KEY `fk_account_idx` (`account_id`, `delete_time`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# down
drop table `system`;
