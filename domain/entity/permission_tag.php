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
        $this->has_many('account_permission_tags', 'account_permission_tag');
    }/*}}}*/

    public static function create(system $system, $tag_name)
    {/*{{{*/
        $pt =  parent::init();
        $pt->system = $system;
        $pt->name = $tag_name;

        return $pt;
    }/*}}}*/

    public function has_authorized_account(account $account)
    {/*{{{*/
        foreach ($this->account_permission_tags as $account_permission_tag) {

            if ((! $account_permission_tag->is_deleted()) && $account_permission_tag->account_id === $account->id) {
                return true;
            }
        }

        return false;
    }/*}}}*/

    public function authorized_account_count()
    {/*{{{*/
        $account_permission_tags = $this->account_permission_tags;

        $count = 0;

        foreach ($account_permission_tags as $account_permission_tag) {
            if ($account_permission_tag->is_not_null()) {
                $count ++;
            }
        }

        return $count;
    }/*}}}*/
}
