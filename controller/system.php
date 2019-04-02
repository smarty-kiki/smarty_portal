<?php

if_get('/systems', function ()
{/*{{{*/
    $account = get_logined_account();

    $systems = dao('system')->find_all_by_admin_account($account);

    return render('system/list', [
        'systems' => $systems,
    ]);
});/*}}}*/

if_get('/systems/add', function ()
{/*{{{*/
    $account = get_logined_account();

    if ($account->is_admin()) {
        $accounts = dao('account')->find_all_valid();
    } else {
        $accounts = [$account->id => $account];
    }

    return render('system/add', [
        'choice_accounts' => $accounts,
    ]);
});/*}}}*/

if_post('/systems/add', function ()
{/*{{{*/
    $account = get_logined_account();

    $inputs = [];
    list(
        $inputs['name'],
        $inputs['api_authorized_ip'],
        $inputs['account_id']
    ) = input_list(
        'name',
        'api_authorized_ip',
        'account_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    otherwise($account->is_admin() || $account->id === $inputs['account_id'], '非管理员不能创建非自己管理的系统');

    $system = system::create();

    foreach ($inputs as $property => $value) {
        $system->{$property} = $value;
    }

    $system->generate_token();

    return redirect('/systems');
});/*}}}*/

if_get('/systems/update/*', function ($system_id)
{/*{{{*/
    $account = get_logined_account();

    $system = dao('system')->find($system_id);
    otherwise($system->is_not_null(), '系统未找到');
    otherwise($account->is_admin() || $system->is_administered_by_account($account), '没有该系统的管理权限');

    if ($account->is_admin()) {
        $accounts = dao('account')->find_all_valid();
    } else {
        $accounts = [$account->id => $account];
    }

    return render('system/update', [
        'system' => $system,
        'choice_accounts' => $accounts,
    ]);
});/*}}}*/

if_post('/systems/update/*', function ($system_id)
{/*{{{*/
    $account = get_logined_account();

    $system = dao('system')->find($system_id);
    otherwise($system->is_not_null(), '系统未找到');
    otherwise($account->is_admin() || $system->is_administered_by_account($account), '没有该系统的管理权限');

    $inputs = [];
    list(
        $inputs['name'],
        $inputs['api_authorized_token'],
        $inputs['api_authorized_ip'],
        $inputs['account_id']
    ) = input_list(
        'name',
        'api_authorized_token',
        'api_authorized_ip',
        'account_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    foreach ($inputs as $property => $value) {
        if ($property === 'api_authorized_token' && $value !== $system->api_authorized_token) {
            $system->generate_token();
        } else {
            $system->{$property} = $value;
        }
    }

    redirect('/systems');
});/*}}}*/

if_post('/systems/delete/*', function ($system_id)
{/*{{{*/
    $account = get_logined_account();

    $system = dao('system')->find($system_id);
    otherwise($system->is_not_null(), '系统未找到');
    otherwise($account->is_admin() || $system->is_administered_by_account($account), '没有该系统的管理权限');

    $system->delete();

    redirect('/systems');
});/*}}}*/
