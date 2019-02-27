<?php

if_get('/', function ()
{
    $account = get_logined_account();

    return render('index/frame', [
        'current_account' => $account,
    ]);
});

if_get('/dashboard', function ()
{
    return render('index/index');
});

if_get('/login', function ()
{
    return render('index/login', [
        'refer' => input('refer', ''),
    ]);
});

if_post('/login', function ()
{
    $email = input_safe('email');
    $password = input_safe('password');
    $refer = input('refer', '/');

    otherwise(not_null($email), '邮箱不能为空');
    otherwise(not_null($password), '密码不能为空');

    $account = dao('account')->find_by_email_and_valid($email);
    otherwise($account->is_not_null(), '账户不存在');

    account_login($account, $password);

    redirect($refer);
});
