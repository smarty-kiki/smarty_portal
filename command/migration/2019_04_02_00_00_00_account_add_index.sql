# up
alter table `account` add index `idx_sign_status_delete_time` (`sign`, `status`, `delete_time`);

# down
alter table `account` drop index `idx_sign_status_delete_time`;
