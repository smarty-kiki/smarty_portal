<?php

class system_dao extends dao
{
    protected $table_name = 'system';
    protected $db_config_key = 'default';

    public function find_all_by_admin_account(account $account)
    {/*{{{*/
        if ($account->is_admin()) {

            return $this->find_all();
        } else {

            return $this->find_all_by_column([
                'account_id' => $account->id,
            ]);
        }
    }/*}}}*/

    public function find_by_token($token)
    {/*{{{*/
        return $this->find_by_column([
            'api_authorized_token' => $token,
        ]);
    }/*}}}*/
}
