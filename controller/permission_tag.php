<?php

if_get('/permission_tags', function ()
{/*{{{*/
    $account = get_logined_account();

    $systems = dao('system')->find_all_by_admin_account($account);
    otherwise(not_empty($systems), 'no administered system');

    $permission_tags = dao('permission_tag')->find_all_by_system_ids(array_keys($systems));

    relationship_batch_load($permission_tags, 'system');
    relationship_batch_load($permission_tags, 'account_permission_tags');

    return render('permission_tag/list', [
        'permission_tags' => $permission_tags,
    ]);
});/*}}}*/

if_post('/permission_tags/delete/*', function ($permission_tag_id)
{/*{{{*/
    $account = get_logined_account();

    $permission_tag = dao('permission_tag')->find($permission_tag_id);
    otherwise($permission_tag->is_not_null(), 'permission_tag not found');

    $systems = dao('system')->find_all_by_admin_account($account);
    otherwise(isset($systems[$permission_tag->system_id]), 'permission_tag not authorized');

    $permission_tag->delete();

    redirect('/permission_tags');
});/*}}}*/
