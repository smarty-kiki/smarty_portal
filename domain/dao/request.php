<?php

class request_dao extends dao
{
    protected $table_name = 'request';
    protected $db_config_key = 'default';

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_column([
            'system_id' => $system->id,
        ]);
    }/*}}}*/

    public function find_by_system_account_url(system $system, account $account, $url)
    {/*{{{*/
        if ($account->is_admin() || $system->is_administered_by_account($account)) {

            return $this->find_by_sql('
            select r.* from request r
            inner join system s on s.id = r.system_id and s.delete_time is null
            where r.delete_time is null and s.id = :system_id
            ', [
                ':system_id' => $system->id,
            ]);
        } else {

            return $this->find_by_sql('
            select r.* from request r
            inner join request_permission_tag rpt on rpt.request_id = r.id and rpt.delete_time is null
            inner join permission_tag pt on pt.id = rpt.permission_tag_id and pt.delete_time is null
            inner join account_permission_tag apt on apt.permission_tag_id = pt.id and apt.delete_time is null
            where apt.account_id = :account_id and r.system_id = :system_id and r.url = :url and r.delete_time is null
            ', [
                ':url' => $url,
                ':system_id' => $system->id,
                ':account_id' => $account->id,
            ]);
        }
    }/*}}}*/
}
