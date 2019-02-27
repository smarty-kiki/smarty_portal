<?php

command('account:add-admin', '添加管理员账号', function ()
{
    $email = command_paramater('email');
    $password = command_paramater('password');

    $account = dao('account')->find_by_email_and_valid($email);
    otherwise($account->is_null(), '账户已存在');

    $account = unit_of_work(function () use ($email, $password) {
        return account::create($email, $password, account::IS_ADMIN_YES);
    });

    echo '已创建账户，ID 为 '.$account->id."\n";
});
