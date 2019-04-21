<?php

class request extends entity
{
    public $structs = [
        'name' => '',
        'url' => '',
        'system_id' => '',
    ];

    public static $entity_display_name = '请求';
    public static $entity_description = '请求';

    public static $struct_types = [
        'name' => 'text',
        'url' => 'text',
        'system_id' => 'number',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'url' => '地址',
        'system_id' => '系统ID',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'url' => '地址',
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

    public static function create($name, $url, system $system)
    {/*{{{*/
        $r = parent::init();

        $r->name = $name;
        $r->url = $url;
        $r->system = $system;

        return $r;
    }/*}}}*/

}
