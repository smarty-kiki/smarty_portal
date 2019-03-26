<?php

if_get('/permission_tags', function ()
{/*{{{*/
    $inputs = [];
    list(
        $inputs['name'],
        $inputs['system_id']
    ) = input_list(
        'name',
        'system_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    $inputs['delete_time'] = null;

    $permission_tags = dao('permission_tag')->find_all_by_column($inputs);

    relationship_batch_load($permission_tags, 'system');
    relationship_batch_load($permission_tags, 'account_permission_tags');

    return render('permission_tag/list', [
        'permission_tags' => $permission_tags,
    ]);
});/*}}}*/

if_post('/permission_tags/delete/*', function ($permission_tag_id)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find($permission_tag_id);

    otherwise($permission_tag->is_not_null(), 'permission_tag not found');

    $permission_tag->delete();

    redirect('/permission_tags');
});/*}}}*/
