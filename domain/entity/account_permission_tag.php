<?php

class account_permission_tag extends entity
{
    public $structs = [
        'account_id' => '',
        'permission_tag_id' => '',
    ];

    public static $entity_display_name = '账户权限标签关系';
    public static $entity_description = '账户权限标签关系';

    public static $struct_types = [
        'account_id' => 'number',
        'permission_tag_id' => 'number',
    ];

    public static $struct_display_names = [
        'account_id' => '账号ID',
        'permission_tag_id' => '权限标签ID',
    ];

    public static $struct_descriptions = [
        'account_id' => '账号ID',
        'permission_tag_id' => '权限标签ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('account');
        $this->belongs_to('permission_tag');
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

}