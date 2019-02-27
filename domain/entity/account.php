<?php

class account extends entity
{
    public $structs = [
        'nick_name' => '',
        'email' => '',
        'password' => '',
        'sign' => '',
        'last_login_ip' => '',
        'now_login_ip' => '',
        'is_admin' => '',
        'status' => '',
    ];

    public static $entity_display_name = '账号';
    public static $entity_description = '登陆使用的账号';

    public static $struct_types = [
        'nick_name' => 'text',
        'email' => 'text',
        'password' => 'text',
        'sign' => 'text',
        'last_login_ip' => 'text',
        'now_login_ip' => 'text',
        'is_admin' => 'enum',
        'status' => 'enum',
    ];

    public static $struct_display_names = [
        'nick_name' => '昵称',
        'email' => '邮箱',
        'password' => '密码',
        'sign' => '登陆标记',
        'last_login_ip' => '上次登陆IP',
        'now_login_ip' => '本次登陆IP',
        'is_admin' => '是否门户管理员',
        'status' => '状态',
    ];

    public static $struct_descriptions = [
        'nick_name' => '昵称',
        'email' => '邮箱',
        'password' => '密码',
        'sign' => '登陆标记',
        'last_login_ip' => '上次登陆IP',
        'now_login_ip' => '本次登陆IP',
        'is_admin' => '是否门户管理员',
        'status' => '状态',
    ];

    const IS_ADMIN_YES = 'YES';
    const IS_ADMIN_NO = 'NO';

    const IS_ADMIN_MAPS = [
        self::IS_ADMIN_YES => '是',
        self::IS_ADMIN_NO => '否',
    ];

    const STATUS_VALID = 'VALID';
    const STATUS_INVALID = 'INVALID';

    const STATUS_MAPS = [
        self::STATUS_VALID => '有效',
        self::STATUS_INVALID => '无效',
    ];

    public static $struct_formats = [
        'is_admin' => self::IS_ADMIN_MAPS,
        'status' => self::STATUS_MAPS,
    ];

    public static $struct_format_descriptions = [
        'is_admin' => '',
        'status' => '',
    ];

    public function __construct()
    {/*{{{*/
        
    }/*}}}*/

    public static function create($email, $password, $is_admin = self::IS_ADMIN_NO)
    {/*{{{*/
        otherwise(array_key_exists($is_admin, self::IS_ADMIN_MAPS), '无效的 is_admin 参数值');

        $account = parent::init();
        $account->email = $email;
        $account->password = $password;
        $account->set_valid();
        $account->is_admin = $is_admin;

        return $account;
    }/*}}}*/

    public function get_is_admin_description()
    {/*{{{*/
        return self::IS_ADMIN_MAPS[$this->is_admin];
    }/*}}}*/

    public function get_status_description()
    {/*{{{*/
        return self::STATUS_MAPS[$this->status];
    }/*}}}*/

    public function is_correct_password($password)
    {/*{{{*/
        return $this->password === md5($password);
    }/*}}}*/

    public function prepare_set_password($password)
    {/*{{{*/
        $this->sign = '';

        return md5($password);
    }/*}}}*/

    public function is_status_valid()
    {/*{{{*/
        return $this->status === self::STATUS_VALID;
    }/*}}}*/

    public function set_valid()
    {/*{{{*/
        return $this->status = self::STATUS_VALID;
    }/*}}}*/

    public function login($ip, $password)
    {/*{{{*/
        otherwise($this->is_correct_password($password), '密码错误');
        otherwise($this->is_status_valid(), '账号无效');

        $this->last_login_ip = $this->now_login_ip;
        $this->now_login_ip = $ip;

        return $this->sign = md5($this->email.$this->password.$this->now_login_ip.datetime());
    }/*}}}*/

    public function get_display_name()
    {/*{{{*/
        return $this->nick_name ?: $this->email;
    }/*}}}*/

    public function is_admin()
    {/*{{{*/
        return $this->is_admin === self::IS_ADMIN_YES;
    }/*}}}*/

}
