<?php

function menu_recursive_render(array $menu_infos = [], $ul_style = '')
{/*{{{*/
    if (empty($menu_infos)) {
        return '';
    }

    $html = "<ul $ul_style>";

    foreach ($menu_infos as $menu_info) {

        $menu = $menu_info['entity'];

        $html .= '  <li class="'.($menu->url? md5($menu->url): '').'">';

        if ($menu->url) {

            $html .= '    <a href="'.$menu->url.'" target="frame">'.$menu->name.'</a>';
        } else {

            $html .= '<strong>'.$menu->name.'</strong>';

            $html .= menu_recursive_render($menu_info['nodes'], 'style="margin: 0px 10px 0px 10px;"');
        }
        $html .= '  </li>';
    }
            
    $html .= '</ul>';

    return $html;
}/*}}}*/
