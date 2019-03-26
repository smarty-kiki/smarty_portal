<?php

if_get('/account_permission_tags', function ()
{/*{{{*/
    $account = get_logined_account();

    if ($account->is_admin()) {
        $systems = dao('system')->find_all_by_column(['delete_time' => null]);
    } else {
        $systems = dao('system')->find_all_by_admin_account($account);
    }

    relationship_batch_load($systems, 'permission_tags.account_permission_tags.account');

    $accounts = dao('account')->find_all_valid();

    return render('account_permission_tag/list', [
        'systems' => $systems,
        'accounts' => $accounts,
    ]);
});/*}}}*/

if_post('/account_permission_tags', function ()
{/*{{{*/
    $account = get_logined_account();

    if ($account->is_admin()) {
        $systems = dao('system')->find_all_by_column(['delete_time' => null]);
    } else {
        $systems = dao('system')->find_all_by_admin_account($account);
    }

    $permission_tags = relationship_batch_load($systems, 'permission_tags');
    $account_permission_tags = relationship_batch_load($systems, 'permission_tags.account_permission_tags');

    foreach ($account_permission_tags as $account_permission_tag) {
        $account_permission_tag->force_delete();
    }

    $accounts = dao('account')->find_all_valid();

    foreach ($_POST as $key => $value) {

        if ($value) {

            $ids = explode('_', $key);

            if (isset($accounts[$ids[0]]) && isset($permission_tags[$ids[1]])) {
                $account = $accounts[$ids[0]];
                $permission_tag = $permission_tags[$ids[1]];

                account_permission_tag::create($account, $permission_tag);
            }
        }
    }

    return redirect('/account_permission_tags');
});/*}}}*/
