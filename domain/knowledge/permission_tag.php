<?php

function permission_tag_refresh(system $system, $permission_info)
{/*{{{*/
    $menu_permission_tags = dao('menu_permission_tag')->find_all_by_system($system);

    foreach ($menu_permission_tags as $menu_permission_tag) {

        $menu_permission_tag->delete();
    }

    $menus = dao('menu')->find_all_by_system($system);

    foreach ($menus as $menu) {

        $menu->delete();
    }

    $permission_tag_infos = [];

    permission_recursive_parse($permission_tag_infos, $system, $permission_info);
}/*}}}*/

function permission_tag_find_or_create(system $system, $tag_name)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find_by_system_tag_name($system, $tag_name);

    if ($permission_tag->is_null()) {
        $permission_tag = permission_tag::create($system, $tag_name);
    }

    return $permission_tag;
}/*}}}*/

function permission_recursive_parse(&$permission_tag_infos, $system, $node, $parent_menu = null, $level = menu::ROOT_LEVEL)
{/*{{{*/
    foreach ($node['menus'] as $menu_info) {

        if (isset($menu_info['url'])) {

            otherwise(! isset($menu_info['menus']), 'menu ['.$menu_info['name'].'] should not have property [menus]');

            $menu = menu::create($menu_info['name'], $menu_info['url'], $level, $system, $parent_menu);

            foreach ($menu_info['permission_tags'] as $tag_name) {

                if (! isset($permission_tag_infos[$tag_name])) {

                    $permission_tag_infos[$tag_name] = permission_tag_find_or_create($system, $tag_name);
                }

                menu_permission_tag::create($permission_tag_infos[$tag_name], $menu);
            }

        } else {

            otherwise(! isset($menu_info['permission_tags']), 'menu ['.$menu_info['name'].'] should not have property [permission_tags]');

            $menu = menu::create($menu_info['name'], '', $level, $system, $parent_menu);

            permission_recursive_parse($permission_tag_infos, $system, $menu_info, $menu, $level + 1);
        }
    }
};/*}}}*/
