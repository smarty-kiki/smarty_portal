<?php

class menu_permission_tag_dao extends dao
{
    protected $table_name = 'menu_permission_tag';
    protected $db_config_key = 'default';

    public function find_all_by_permission_tag(permission_tag $permission_tag)
    {/*{{{*/
        return $this->find_all_by_condition('permission_tag_id = :permission_tag_id and delete_time is null', [
            ':permission_tag_id' => $permission_tag->id,
        ]);
    }/*}}}*/

    public function find_all_by_not_in_ids(array $not_in_ids)
    {/*{{{*/
        if (empty($not_in_ids)) {
            $not_in_ids[] = 0;
        }

        return $this->find_all_by_condition('
            id not in :not_in_ids
            and delete_time is null',
            [
                ':not_in_ids' => $not_in_ids,
            ]);
    }/*}}}*/
}
