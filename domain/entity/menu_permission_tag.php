<?php

class menu_permission_tag extends entity
{
    public $structs = [
        'permission_tag_id' => '',
        'menu_id' => '',
    ];

    public static $entity_display_name = '地址权限标签关联';
    public static $entity_description = '地址权限标签关联';

    public static $struct_types = [
        'permission_tag_id' => 'number',
        'menu_id' => 'number',
    ];

    public static $struct_display_names = [
        'permission_tag_id' => '权限标签ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_descriptions = [
        'permission_tag_id' => '权限标签ID',
        'menu_id' => '目录ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('permission_tag');
        $this->belongs_to('menu');
    }/*}}}*/

    public static function create(permission_tag $permission_tag, menu $menu)
    {/*{{{*/
        $mpt = parent::init();
        $mpt->permission_tag = $permission_tag;
        $mpt->menu = $menu;

        return $mpt;
    }/*}}}*/

}
