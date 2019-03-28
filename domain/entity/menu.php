<?php

class menu extends entity
{
    public $structs = [
        'name' => '',
        'url' => '',
        'level' => '',
        'system_id' => '',
        'menu_id' => '',
    ];

    public static $entity_display_name = '目录';
    public static $entity_description = '目录';

    public static $struct_types = [
        'name' => 'text',
        'url' => 'text',
        'level' => 'number',
        'system_id' => 'number',
        'menu_id' => 'number',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'url' => '地址',
        'level' => '等级',
        'system_id' => '系统ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'url' => '地址',
        'level' => '等级',
        'system_id' => '系统ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    const ROOT_LEVEL = 0;
    const NAME_MAX_LENGTH = 8;

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
        $this->belongs_to('menu');
    }/*}}}*/

    public static function create($name, $url, $level, system $system, $menu = null)
    {/*{{{*/
        otherwise(mb_strlen($name) + $level < self::NAME_MAX_LENGTH, 'menu ['.$name.'] character count of name greater than '.(self::NAME_MAX_LENGTH - $level));

        $m = parent::init();

        $m->name = $name;
        $m->url = $url;
        $m->level = $level;
        $m->system = $system;

        if ($menu instanceof menu) {
            $m->menu = $menu;
        }

        return $m;
    }/*}}}*/

}
