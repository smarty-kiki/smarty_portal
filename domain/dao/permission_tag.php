<?php

class permission_tag_dao extends dao
{
    protected $table_name = 'permission_tag';
    protected $db_config_key = 'default';

    public function find_by_system_tag_name(system $system, $tag_name)
    {/*{{{*/
        return $this->find_by_condition('system_id = :system_id and name = :name and delete_time is null', [
            ':system_id' => $system->id,
            ':name' => $tag_name,
        ]);
    }/*}}}*/

    public function find_all_by_system_ids(array $system_ids = [])
    {/*{{{*/
        if (empty($system_ids)) {
            return [];
        }

        return $this->find_all_by_condition('delete_time is null and system_id in :system_ids', [
            ':system_ids' => $system_ids,
        ]);
    }/*}}}*/

    public function find_all_by_system_account(system $system, account $account)
    {/*{{{*/
        if ($account->is_admin() || $system->is_administered_by_account($account)) {

            return $this->find_all_by_system($system);
        } else {

            return $this->find_all_by_sql('
            select pt.* from permission_tag pt
            inner join account_permission_tag apt on apt.permission_tag_id = pt.id and apt.delete_time is null
            where pt.system_id = :system_id and pt.delete_time is null and apt.account_id = :account_id
            ', [
                ':system_id' => $system->id,
                ':account_id' => $account->id,
            ]);
        }
    }/*}}}*/

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_sql('
                select * from permission_tag
                where system_id = :system_id
                delete_time is null
            ', [
                ':system_id' => $system->id
            ]);
    }/*}}}*/
}
