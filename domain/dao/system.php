<?php

class system_dao extends dao
{
    protected $table_name = 'system';
    protected $db_config_key = 'default';

    public function find_all_by_admin_account(account $account)
    {/*{{{*/
        return $this->find_all_by_column([
            'account_id' => $account->id,
            'delete_time' => null,
        ]);
    }/*}}}*/
}
