<?php

class request_permission_tag_dao extends dao
{
    protected $table_name = 'request_permission_tag';
    protected $db_config_key = 'default';

    public function find_all_by_system(system $system)
    {/*{{{*/
        return $this->find_all_by_sql('
            select rpt.*
            from request_permission_tag rpt
            inner join permission_tag pt on pt.id = rpt.permission_tag_id and pt.delete_time is null
            where pt.system_id = :system_id
            and rpt.delete_time is null
            ', [
            ':system_id' => $system->id,
        ]);
    }/*}}}*/
}
