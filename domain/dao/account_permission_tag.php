<?php

class account_permission_tag_dao extends dao
{
    protected $table_name = 'account_permission_tag';
    protected $db_config_key = 'default';

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_sql('
            select apt.* from account_permission_tag apt
            inner join permission_tag pt on pt.id = apt.permission_tag_id and pt.delete_time is null
            inner join system s on s.id = pt.system_id and s.delete_time is null
            where s.id = :system_id
        ', [
            ':system_id' => $system->id,
        ]);
    }/*}}}*/

    public function find_all_by_account(account $account)
    {/*{{{*/
        return $this->find_all_by_sql('
            select apt.* from account_permission_tag apt
            inner join account a on a.id = apt.account_id and a.delete_time is null
            where a.id = :account_id
            ', [
                ':account_id' => $account->id,
            ]);
    }/*}}}*/
}
