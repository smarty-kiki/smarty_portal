<?php

function permission_tag_find_or_create(system $system, $tag_name)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find_by_system_tag_name($system, $tag_name);

    if ($permission_tag->is_null()) {
        $permission_tag = permission_tag::create($system, $tag_name);
    }

    return $permission_tag;
}/*}}}*/

function permission_tag_refresh(system $system, $permission_tag_infos)
{/*{{{*/
    $retain_menu_ids = [];
    $retain_menu_permission_tag_ids = [];

    foreach ($permission_tag_infos as $tag_name => $permission_tag_info) {

        $permission_tag = permission_tag_find_or_create($system, $tag_name);

        $menu_permission_tags = dao('menu_permission_tag')->find_all_by_permission_tag($permission_tag);

        $retain_menu_ids_indexed_by_id = array_flip($permission_tag_info);

        foreach ($menu_permission_tags as $id => $menu_permission_tag) {

            $menu = $menu_permission_tag->menu;

            if (isset($retain_menu_ids_indexed_by_id[$menu->id])) {

                $retain_menu_permission_tag_ids[] = $menu_permission_tag->id;
                $retain_menu_ids[] = $menu->id;

                unset($retain_menu_ids_indexed_by_id[$menu->id]);
            }
        }

        foreach ($retain_menu_ids_indexed_by_id as $menu_id => $what_ever) {
            menu_permission_tag::create($permission_tag, dao('menu')->find($menu_id));
        }
    }

    $retain_menu_ids = array_unique($retain_menu_ids);
    $retain_menu_permission_tag_ids = array_unique($retain_menu_permission_tag_ids);

    $to_delete_menu_permission_tags = dao('menu_permission_tag')->find_all_by_not_in_ids($retain_menu_permission_tag_ids);

    foreach ($to_delete_menu_permission_tags as $menu_permission_tag) {
        $menu_permission_tag->delete();
    }

    $to_delete_menus = dao('menu')->find_all_by_system_and_not_in_ids($system, $retain_menu_ids);

    foreach ($to_delete_menus as $menu) {
        $menu->delete();
    }
}/*}}}*/

function permission_recursive_parse(&$permission_tag_infos, &$system, $node, $parent_menu = null, $l = 0)
{/*{{{*/
    foreach ($node['menus'] as $menu) {

        if (isset($menu['url'])) {

            $m = menu_find_or_create($menu['name'], $menu['url'], $l, $system, $parent_menu);

            foreach ($menu['permission_tags'] as $tag_name) {

                if (! isset($permission_tag_infos[$tag_name])) {
                    $permission_tag_infos[$tag_name] = [];
                }
                $permission_tag_infos[$tag_name][] = $m->id;
            }

        } else {

            $m = menu_find_or_create($menu['name'], '', $l, $system, $parent_menu);

            permission_recursive_parse($permission_tag_infos, $system, $menu, $m, $l + 1);
        }
    }
};/*}}}*/
