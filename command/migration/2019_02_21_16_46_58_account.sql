# up
CREATE TABLE `account` (
    `id` bigint(20) NOT NULL,
    `version` int(11) NOT NULL,
    `create_time` datetime DEFAULT NULL,
    `update_time` datetime DEFAULT NULL,
    `delete_time` datetime DEFAULT NULL,
    `nick_name` varchar(45) NOT NULL,
    `email` varchar(45) NOT NULL,
    `password` varchar(45) NOT NULL,
    `sign` varchar(45) NOT NULL,
    `last_login_ip` varchar(45) NOT NULL,
    `now_login_ip` varchar(45) NOT NULL,
    `is_admin` varchar(45) NOT NULL,
    `status` varchar(45) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# down
drop table `account`;