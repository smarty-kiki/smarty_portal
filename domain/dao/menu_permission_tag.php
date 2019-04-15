<?php

class menu_permission_tag_dao extends dao
{
    protected $table_name = 'menu_permission_tag';
    protected $db_config_key = 'default';

    public function find_all_by_permission_tag(permission_tag $permission_tag)
    {/*{{{*/
        return $this->find_all_by_column([
            'permission_tag_id' => $permission_tag->id,
        ]);
    }/*}}}*/

    public function find_all_by_not_in_ids(array $not_in_ids)
    {/*{{{*/
        if (empty($not_in_ids)) {
            $not_in_ids[] = 0;
        }

        return $this->find_all_by_column([
            'id not' => $not_in_ids,
        ]);
    }/*}}}*/

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_sql('
            select mpt.*
            from menu_permission_tag mpt
            inner join permission_tag pt on pt.id = mpt.permission_tag_id and pt.delete_time is null
            where pt.system_id = :system_id
            and mpt.delete_time is null
            ', [
            ':system_id' => $system->id,
        ]);
    }/*}}}*/
}
