<?php

class system extends entity
{
    public $structs = [
        'name' => '',
        'api_authorized_token' => '',
        'api_authorized_ip' => '',
        'account_id' => '',
    ];

    public static $entity_display_name = '系统';
    public static $entity_description = '可以通过统一入口平台使用的系统';

    public static $struct_types = [
        'name' => 'text',
        'api_authorized_token' => 'text',
        'api_authorized_ip' => 'text',
        'account_id' => 'number',
    ];

    public static $struct_display_names = [
        'name' => '名称',
        'api_authorized_token' => '系统接口口令',
        'api_authorized_ip' => '系统接口授权IP',
        'account_id' => '账号ID',
    ];

    public static $struct_descriptions = [
        'name' => '名称',
        'api_authorized_token' => '',
        'api_authorized_ip' => '系统接口授权IP',
        'account_id' => '账号ID',
    ];

    public static $struct_formats = [
        
    ];

    public static $struct_format_descriptions = [
        
    ];

    public function __construct()
    {/*{{{*/
        $this->belongs_to('account');
        $this->has_many('permission_tags', 'permission_tag');
    }/*}}}*/

    public static function create()
    {/*{{{*/
        return parent::init();
    }/*}}}*/

    public function is_administered_by_account(account $account)
    {/*{{{*/
        return $this->account_id === $account->id;
    }/*}}}*/

    public function generate_token()
    {/*{{{*/
        return $this->api_authorized_token = md5(uniqid(mt_rand(), true));
    }/*}}}*/

}
