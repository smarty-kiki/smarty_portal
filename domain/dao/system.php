<?php

class system_dao extends dao
{
    protected $table_name = 'system';
    protected $db_config_key = 'default';

    public function find_all_by_admin_account(account $account)
    {/*{{{*/
        if ($account->is_admin()) {

            $columns = [
                'delete_time' => null
            ];
        } else {

            $columns = [
                'account_id' => $account->id,
                'delete_time' => null,
            ];
        }

        return $this->find_all_by_column($columns);
    }/*}}}*/

    public function find_by_token($token)
    {/*{{{*/
        return $this->find_by_condition('api_authorized_token = :token and delete_time is null', [
            ':token' => $token,
        ]);
    }/*}}}*/
}
