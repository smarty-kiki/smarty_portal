<?php

class url_permission_tag extends entity
{
    public $structs = [
        'permission_tag_id' => '',
        'url_id' => '',
    ];

    public static $entity_display_name = '地址权限标签关联';
    public static $entity_description = '地址权限标签关联';

    public static $struct_types = [
        'permission_tag_id' => 'number',
        'url_id' => 'number',
    ];

    public static $struct_display_names = [
        'permission_tag_id' => '权限标签ID',
        'url_id' => '网页ID',
    ];

    public static $struct_descriptions = [
        'permission_tag_id' => '权限标签ID',
        'url_id' => '网页ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('permission_tag');
        $this->belongs_to('url');
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

}