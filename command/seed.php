<?php

function seed_echo()
{/*{{{*/
    $args = func_get_args();

    $args[0] = '[seed]'.$args[0]."\n";

    echo call_user_func_array('sprintf', $args);
}/*}}}*/

command('seed', '测试数据初始化', function ()
{
    unit_of_work(function ()
    {
        $email = '123@qq.com';
        $password = '123';

        # 管理员账户初始化
        $account = account::create($email, $password, account::IS_ADMIN_YES);
        seed_echo('已创建测试账户，邮箱为 [%s], 密码为 [%s]', $email, $password);

        # 系统初始化
        $system = system::create();
        $system->name = '数字货币';
        $system->account = $account;
        $system->generate_token();
        seed_echo('已创建测试系统 [%s]，token 为 [%s]', $system->name, $system->api_authorized_token);

        # 注册系统权限
        $parent_menu = menu::create('分析', '', menu::ROOT_LEVEL, $system, null);
        $child_menu = menu::create('看板', 'http://coin.yao-yang.cn/', 1, $system, $parent_menu);
        seed_echo('已创建测试菜单 [%s] [%s]', $parent_menu->name, $child_menu->name);
    });
});
