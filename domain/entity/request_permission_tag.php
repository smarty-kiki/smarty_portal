<?php

class request_permission_tag extends entity
{
    public $structs = [
        'permission_tag_id' => '',
        'request_id' => '',
    ];

    public static $entity_display_name = '请求权限标签关联';
    public static $entity_description = '请求权限标签关联';

    public static $struct_types = [
        'permission_tag_id' => 'number',
        'request_id' => 'number',
    ];

    public static $struct_display_names = [
        'permission_tag_id' => '权限标签ID',
        'request_id' => '请求ID',
    ];

    public static $struct_descriptions = [
        'permission_tag_id' => '权限标签ID',
        'request_id' => '请求ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('permission_tag');
        $this->belongs_to('request');
    }/*}}}*/

    public static function create(permission_tag $permission_tag, request $request)
    {/*{{{*/
        $rpt = parent::init();
        $rpt->permission_tag = $permission_tag;
        $rpt->request = $request;

        return $rpt;
    }/*}}}*/

}
