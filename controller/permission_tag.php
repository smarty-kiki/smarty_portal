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

    return render('permission_tag/list', [
        'permission_tags' =>dao('permission_tag')->find_all_by_column($inputs),
    ]);
});/*}}}*/

if_get('/permission_tags/add', function ()
{/*{{{*/
    return render('permission_tag/add');
});/*}}}*/

if_post('/permission_tags/add', function ()
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

    $permission_tag = permission_tag::create();

    foreach ($inputs as $property => $value) {
        $permission_tag->{$property} = $value;
    }

    return redirect('/permission_tags');
});/*}}}*/

if_get('/permission_tags/update/*', function ($permission_tag_id)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find($permission_tag_id);
    otherwise($permission_tag->is_not_null(), 'permission_tag not found');

    return render('permission_tag/update', [
        'permission_tag' => $permission_tag,
    ]);
});/*}}}*/

if_post('/permission_tags/update/*', function ($permission_tag_id)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find($permission_tag_id);
    otherwise($permission_tag->is_not_null(), 'permission_tag not found');

    $inputs = [];
    list(
        $inputs['name'],
        $inputs['system_id']
    ) = input_list(
        'name',
        'system_id'
    );
    $inputs = array_filter($inputs, 'not_null');

    foreach ($inputs as $property => $value) {
        $permission_tag->{$property} = $value;
    }

    redirect('/permission_tags');
});/*}}}*/

if_post('/permission_tags/delete/*', function ($permission_tag_id)
{/*{{{*/
    $permission_tag = dao('permission_tag')->find($permission_tag_id);
    otherwise($permission_tag->is_not_null(), 'permission_tag not found');

    $permission_tag->delete();

    redirect('/permission_tags');
});/*}}}*/