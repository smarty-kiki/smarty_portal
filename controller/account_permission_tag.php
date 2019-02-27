<?php

if_get('/account_permission_tags', function ()
{/*{{{*/
    $account = get_logined_account();

    if ($account->is_admin()) {
        $systems = dao('system')->find_all_by_column(['delete_time' => null]);
    } else {
        $systems = dao('system')->find_all_by_admin_account($account);
    }

    $account_permission_tags = [];
    foreach ($systems as $system) {
        $account_permission_tags = array_merge($account_permission_tags, $system->permission_tags);
    }

    //todo::kiki
    return render('account_permission_tag/list', [
        'account_permission_tags' => $account_permission_tags,
    ]);
});/*}}}*/

if_get('/account_permission_tags/add', function ()
{/*{{{*/
    get_logined_account();

    return render('account_permission_tag/add');
});/*}}}*/

if_post('/account_permission_tags/add', function ()
{/*{{{*/
    get_logined_account();

    $inputs = [];
    list(
        $inputs['account_id'],
        $inputs['permission_tag_id']
    ) = input_list(
        'account_id',
        'permission_tag_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    $account_permission_tag = account_permission_tag::create();

    foreach ($inputs as $property => $value) {
        $account_permission_tag->{$property} = $value;
    }

    return redirect('/account_permission_tags');
});/*}}}*/

if_get('/account_permission_tags/update/*', function ($account_permission_tag_id)
{/*{{{*/
    get_logined_account();

    $account_permission_tag = dao('account_permission_tag')->find($account_permission_tag_id);
    otherwise($account_permission_tag->is_not_null(), 'account_permission_tag not found');

    return render('account_permission_tag/update', [
        'account_permission_tag' => $account_permission_tag,
    ]);
});/*}}}*/

if_post('/account_permission_tags/update/*', function ($account_permission_tag_id)
{/*{{{*/
    get_logined_account();

    $account_permission_tag = dao('account_permission_tag')->find($account_permission_tag_id);
    otherwise($account_permission_tag->is_not_null(), 'account_permission_tag not found');

    $inputs = [];
    list(
        $inputs['account_id'],
        $inputs['permission_tag_id']
    ) = input_list(
        'account_id',
        'permission_tag_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    foreach ($inputs as $property => $value) {
        $account_permission_tag->{$property} = $value;
    }

    redirect('/account_permission_tags');
});/*}}}*/

if_post('/account_permission_tags/delete/*', function ($account_permission_tag_id)
{/*{{{*/
    get_logined_account();

    $account_permission_tag = dao('account_permission_tag')->find($account_permission_tag_id);
    otherwise($account_permission_tag->is_not_null(), 'account_permission_tag not found');

    $account_permission_tag->delete();

    redirect('/account_permission_tags');
});/*}}}*/
