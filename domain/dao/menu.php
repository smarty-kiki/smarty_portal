<?php

class menu_dao extends dao
{
    protected $table_name = 'menu';
    protected $db_config_key = 'default';

    public function find_by_system_url(system $system, $url)
    {/*{{{*/
        return $this->find_by_condition('system_id = :system_id and url = :url and delete_time is null', [
            ':system_id' => $system->id,
            ':url' => $url,
        ]);
    }/*}}}*/

    public function find_by_system_name(system $system, $name)
    {/*{{{*/
        return $this->find_by_condition('system_id = :system_id and name = :name and delete_time is null', [
            ':system_id' => $system->id,
            ':name' => $name,
        ]);
    }/*}}}*/

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_condition('system_id = :system_id and delete_time is null', [
            ':system_id' => $system->id,
        ]);
    }/*}}}*/

    public function find_all_by_system_and_not_in_ids(system $system, array $not_in_ids)
    {/*{{{*/
        if (empty($not_in_ids)) {
            $not_in_ids[] = 0;
        }

        return $this->find_all_by_condition('
            system_id = :system_id 
            and id not in :not_in_ids
            and delete_time is null',
            [
                ':system_id' => $system->id,
                ':not_in_ids' => $not_in_ids,
            ]);
    }/*}}}*/
}
