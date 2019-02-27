<?php

class url extends entity
{
    public $structs = [
        'name' => '',
        'url' => '',
    ];

    public static $entity_display_name = '网页';
    public static $entity_description = '网页';

    public static $struct_types = [
        'name' => 'text',
        'url' => 'text',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'url' => '地址',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'url' => '地址',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

}