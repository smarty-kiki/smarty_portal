<?php

function menu_find_or_create($name, $url, $level, system $system, $parent_menu)
{/*{{{*/
    if ($url) {
        $menu = dao('menu')->find_by_system_url($system, $url);

        if ($menu->is_not_null()) {

            $menu->menu = $parent_menu;
            $menu->name = $name;
            $menu->level = $level;

            return $menu;
        }
    } else {

        $menu = dao('menu')->find_by_system_name($system, $url);

        if ($menu->is_not_null()) {

            $menu->menu = $parent_menu;
            $menu->level = $level;
            $menu->url = $url;

            return $menu;
        }
    }

    return menu::create($name, $url, $level, $system, $parent_menu);
}/*}}}*/
