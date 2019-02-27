<?php

class permission_tag extends entity
{
    public $structs = [
        'name' => '',
        'system_id' => '',
    ];

    public static $entity_display_name = '权限标签';
    public static $entity_description = '权限标签';

    public static $struct_types = [
        'name' => 'text',
        'system_id' => 'number',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'system_id' => '系统ID',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'system_id' => '系统ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('system');
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

}