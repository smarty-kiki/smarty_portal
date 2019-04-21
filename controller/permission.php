<?php

if_post('/permission/rewrite', function ()
{/*{{{*/
    $permission_info = yaml_parse(input_post_raw());
    otherwise(isset($permission_info['token']), 'invalid format');

    $token = $permission_info['token'];
    otherwise($token, 'invalid token');

    $system = dao('system')->find_by_token($token);
    otherwise($system->is_not_null(), 'invalid token '.$token);

    if ($system->api_authorized_ip) {
        otherwise(ip() === $system->api_authorized_ip, 'invalid request ip '.ip());
    }

    $system->name = $permission_info['name'];

    permission_tag_refresh($system, $permission_info);

    return $token;
});/*}}}*/

if_get('/permission/query', function ()
{/*{{{*/
    list($url, $system_token, $account_token) = input_list('url', 'system_token', 'account_token');

    otherwise($url, 'invalid url '.$url);

    $account = dao('account')->find_by_sign_and_valid($account_token);
    otherwise($account->is_not_null(), 'invalid account_token '.$account_token);

    $system = dao('system')->find_by_token($system_token);
    otherwise($system->is_not_null(), 'invalid system_token '.$system_token);

    $menu = dao('menu')->find_by_system_account_url($system, $account, $url);

    $request = dao('request')->find_by_system_account_url($system, $account, $url);

    if ($menu->is_not_null() || $request->is_not_null()) {

        $permission_tags = dao('permission_tag')->find_all_by_system_account($system, $account);

        $res = [
            'authorized' => true,
            'account' => [
                'email' => $account->email,
                'nick_name' => $account->nick_name,
                'last_login_ip' => $account->last_login_ip,
                'now_login_ip' => $account->now_login_ip,
                'is_system_admin' => ($account->is_admin() || $system->is_administered_by_account($account)),
            ],
            'permission_tags' => array_build($permission_tags, function ($id, $permission_tag) {
                return [null, $permission_tag->name];
            }),
        ];
    } else {

        $res = [
            'authorized' => false,
        ];
    }

    return $res;
});/*}}}*/
