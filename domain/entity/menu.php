<?php

class menu extends entity
{
    public $structs = [
        'name' => '',
        'level' => '',
        'system_id' => '',
        'menu_id' => '',
    ];

    public static $entity_display_name = '目录';
    public static $entity_description = '目录';

    public static $struct_types = [
        'name' => 'text',
        'level' => 'number',
        'system_id' => 'number',
        'menu_id' => 'number',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'level' => '等级',
        'system_id' => '系统ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'level' => '等级',
        'system_id' => '系统ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
        $this->belongs_to('menu');
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

}