<?php

if_get('/', function ()
{/*{{{*/
    $systems = dao('system')->find_all_by_admin_account($account);

    $menu_infos = dao('menu')->find_all_tree_by_systems_indexed_by_system_id($systems);

    $authorized_menu_infos = dao('menu')->find_all_tree_by_account_authorized($account);

    $system_ids = array_keys($authorized_menu_infos);

    $authorized_systems = dao('system')->find($system_ids);

    return render('index/frame', [
        'current_account' => $account,
        'is_admin_or_system_admin' => ! empty($systems),
        'menu_infos' => array_replace_recursive($menu_infos, $authorized_menu_infos),
        'systems' => array_replace_recursive($systems, $authorized_systems),
    ]);
});/*}}}*/

if_get('/dashboard', function ()
{/*{{{*/
    return render('index/index');
});/*}}}*/

if_get('/login', function ()
{/*{{{*/
    return render('index/login', [
        'refer' => input('refer', '/'),
    ]);
});/*}}}*/

if_post('/login', function ()
{/*{{{*/
    $email = input_safe('email');
    $password = input_safe('password');
    $refer = input('refer', '/');

    otherwise(not_null($email), '邮箱不能为空');
    otherwise(not_null($password), '密码不能为空');

    $account = dao('account')->find_by_email_and_valid($email);
    otherwise($account->is_not_null(), '账户不存在');

    account_login($account, $password);

    return redirect($refer);
});/*}}}*/
