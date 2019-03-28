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
}
