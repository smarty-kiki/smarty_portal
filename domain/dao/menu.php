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

    private function menu_tree(array $menus)
    {/*{{{*/
        if (empty($menus)) {
            return [];
        }

        $menus_indexed_by_level = array_indexed($menus, function ($key, $menu) {

            return [$menu->level, $menu->id, ['entity' => $menu, 'nodes' => []]];
        });

        foreach ($menus_indexed_by_level as $level => $menu_infos) {

            if ($level > menu::ROOT_LEVEL) {

                $parent_level = $level - 1;

                foreach ($menu_infos as $menu_id => $menu_info) {

                    $menu = $menu_info['entity'];

                    $menus_indexed_by_level[$parent_level][$menu->menu_id]['nodes'][$menu->id] = $menu_info;
                }
            } 
        }

        return array_indexed($menus_indexed_by_level[menu::ROOT_LEVEL], function ($menu_id, $menu_info) {

            $menu = $menu_info['entity'];

            return [$menu->system_id, $menu_id, $menu_info];
        });
    }/*}}}*/

    public function find_all_tree_by_systems_indexed_by_system_id(array $systems = [])
    {/*{{{*/
        $system_ids = array_keys($systems);

        if (empty($system_ids)) {
            return [];
        }

        return $this->menu_tree($this->find_all_by_sql('
            select m.* from menu m
            inner join system s on s.id = m.system_id and s.delete_time is null
            where
            m.system_id in :system_ids and m.delete_time is null order by m.level desc
            ', [
            ':system_ids' => $system_ids,
        ]));
    }/*}}}*/

    public function find_all_by_system_and_not_in_ids(system $system, array $not_in_ids)
    {/*{{{*/
        if (empty($not_in_ids)) {
            $not_in_ids[] = 0;
        }

        return $this->find_all_by_condition(
            'system_id = :system_id 
            and id not in :not_in_ids
            and delete_time is null',
            [
                ':system_id' => $system->id,
                ':not_in_ids' => $not_in_ids,
            ]);
    }/*}}}*/

    public function find_all_tree_by_account_authorized(account $account)
    {/*{{{*/
        $sql_template = '
            select m.* from menu m
            inner join system s on s.id = m.system_id and s.delete_time is null
            inner join menu_permission_tag mpt on mpt.menu_id = m.id and mpt.delete_time is null
            inner join permission_tag pt on pt.id = mpt.permission_tag_id and pt.delete_time is null
            inner join account_permission_tag apt on apt.permission_tag_id = pt.id and apt.delete_time is null
            where apt.account_id = :account_id
            order by m.level desc';

        $menus = $this->find_all_by_sql($sql_template, [
            ':account_id' => $account->id,
        ]);

        if (empty($menus)) {
            return [];
        }

        $level_infos = [];

        foreach ($menus as $menu) {

            $level = $menu->level;

            if (! isset($level_infos[$level])) {

                $level_infos[$level] = [];
            }

            $level_infos[$level][] = $menu->menu_id;
        }

        do {

            $ids = reset($level_infos);
            $level = key($level_infos);

            $parent_menus = $this->find_all_by_sql('select * from menu where id in :ids', [
                ':ids' => $ids,
            ]);

            foreach ($parent_menus as $menu) {

                $level = $menu->level;

                if (! isset($level_infos[$level])) {

                    $level_infos[$level] = [];
                }

                $level_infos[$level][] = $menu->menu_id;
            }

            $menus = array_replace($menus, $parent_menus);

            unset($level_infos[$level]);

        } while ($level > 0);

        return $this->menu_tree($menus);
    }/*}}}*/

    public function find_by_system_account_url(system $system, account $account, $url)
    {/*{{{*/
        if ($account->is_admin() || $system->is_administered_by_account($account)) {

            return $this->find_by_sql('
            select m.* from menu m
            inner join system s on s.id = m.system_id and s.delete_time is null
            where m.delete_time is null and s.id = :system_id
            ', [
                ':system_id' => $system->id,
            ]);
        } else {

            return $this->find_by_sql('
            select m.* from menu m
            inner join menu_permission_tag mpt on mpt.menu_id = m.id and mpt.delete_time is null
            inner join permission_tag pt on pt.id = mpt.permission_tag_id and pt.delete_time is null
            inner join account_permission_tag apt on apt.permission_tag_id = pt.id and apt.delete_time is null
            where apt.account_id = :account_id and m.system_id = :system_id and m.url = :url and m.delete_time is null
            ', [
                ':url' => $url,
                ':system_id' => $system->id,
                ':account_id' => $account->id,
            ]);
        }
    }/*}}}*/
}
