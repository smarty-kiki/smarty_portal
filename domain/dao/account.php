<?php

class account_dao extends dao
{
    protected $table_name = 'account';
    protected $db_config_key = 'default';

    public function find_by_email_and_valid($email)
    {/*{{{*/
        return $this->find_by_condition('`email` = :email and `status` = :status and `delete_time` is null', [
            ':status' => account::STATUS_VALID,
            ':email' => $email,
        ]);
    }/*}}}*/

    public function find_by_sign_and_valid($sign)
    {/*{{{*/
        return $this->find_by_condition('`sign` = :sign and `status` = :status and `delete_time` is null', [
            ':status' => account::STATUS_VALID,
            ':sign' => $sign,
        ]);
    }/*}}}*/

    public function find_all_has_permission_of_system_administered_by_account(account $account)
    {/*{{{*/
        $sql_template = '
            select a.*
            from account a
            inner join account_permission_tag apt on apt.account_id = a.id
            inner join permission_tag pt on apt.permission_tag_id = pt.id
            inner join system s on pt.system_id = s.id
            where a.delete_time is null
            and apt.delete_time is null
            and pt.delete_time is null
            and s.delete_time is null
            and s.account_id = :system_account_id
        ';

        return $this->find_all_by_sql($sql_template, [
            ':system_account_id' => $account->id,
        ]);
    }/*}}}*/

    public function find_all_valid()
    {/*{{{*/
        return $this->find_all_by_condition('`status` = :status and `delete_time` is null', [
            ':status' => account::STATUS_VALID,
        ]);
    }/*}}}*/
}
