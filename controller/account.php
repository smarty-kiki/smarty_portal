<?php

if_get('/accounts', function ()
{/*{{{*/
    $account = get_logined_account();

    if ($account->is_admin()) {
        $accounts = dao('account')->find_all_by_column([
            'delete_time' => null,
        ]);
    } else {
        $accounts = dao('account')->find_all_has_permission_of_system_administered_by_account($account);
    }

    return render('account/list', [
        'accounts' => $accounts,
    ]);
});/*}}}*/

if_get('/accounts/add', function ()
{/*{{{*/
    get_logined_account();

    return render('account/add');
});/*}}}*/

if_post('/accounts/add', function ()
{/*{{{*/
    get_logined_account();

    $inputs = [];
    list(
        $inputs['nick_name'],
        $inputs['email'],
        $inputs['password'],
        $inputs['sign'],
        $inputs['last_login_ip'],
        $inputs['now_login_ip'],
        $inputs['is_admin'],
        $inputs['status']
    ) = input_list(
        'nick_name',
        'email',
        'password',
        'sign',
        'last_login_ip',
        'now_login_ip',
        'is_admin',
        'status'
    );
    $inputs = array_filter($inputs, 'not_null');

    $account = account::create($email, $password, $is_admin);

    foreach ($inputs as $property => $value) {
        $account->{$property} = $value;
    }

    return redirect('/accounts');
});/*}}}*/

if_get('/accounts/update/mine', function ()
{/*{{{*/
    $account = get_logined_account();

    return render('account/update_mine', [
        'account' => $account,
    ]);
});/*}}}*/

if_post('/accounts/update/mine', function ()
{/*{{{*/
    $account = get_logined_account();

    list(
        $nick_name,
        $password,
    ) = input_list(
        'nick_name',
        'password'
    );

    $account->nick_name = $nick_name;

    if (not_empty($password)) {
        $account->password = $password;
    }

    redirect('/accounts/update/mine');
});/*}}}*/

if_get('/accounts/update/*', function ($account_id)
{/*{{{*/
    get_logined_account();

    $account = dao('account')->find($account_id);
    otherwise($account->is_not_null(), 'account not found');

    return render('account/update', [
        'account' => $account,
    ]);
});/*}}}*/

if_post('/accounts/update/*', function ($account_id)
{/*{{{*/
    get_logined_account();

    $account = dao('account')->find($account_id);
    otherwise($account->is_not_null(), 'account not found');

    $inputs = [];
    list(
        $inputs['nick_name'],
        $inputs['email'],
        $inputs['password'],
        $inputs['sign'],
        $inputs['last_login_ip'],
        $inputs['now_login_ip'],
        $inputs['is_admin'],
        $inputs['status']
    ) = input_list(
        'nick_name',
        'email',
        'password',
        'sign',
        'last_login_ip',
        'now_login_ip',
        'is_admin',
        'status'
    );
    $inputs = array_filter($inputs, 'not_null');

    if (empty($inputs['password'])) {
        unset($inputs['password']);
    }

    foreach ($inputs as $property => $value) {
        $account->{$property} = $value;
    }

    redirect('/accounts');
});/*}}}*/

if_post('/accounts/delete/*', function ($account_id)
{/*{{{*/
    get_logined_account();

    $account = dao('account')->find($account_id);
    otherwise($account->is_not_null(), 'account not found');

    $account->delete();

    redirect('/accounts');
});/*}}}*/
