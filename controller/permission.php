<?php

if_post('/permission/rewrite', function ()
{
    $token = input('token');
    otherwise($token, 'invalid token');

    $system = dao('system')->find_by_token($token);
    otherwise($system->is_not_null(), 'invalid token '.$token);

    if ($system->api_authorized_ip) {
        otherwise(ip() === $system->api_authorized_ip, 'invalid request ip '.ip());
    }

    $permission_info = yaml_parse(input_post_raw());

    $system->name = $permission_info['name'];

    $permission_tag_infos = [];

    permission_recursive_parse($permission_tag_infos, $system, $permission_info);

    permission_tag_refresh($system, $permission_tag_infos);

    return $token;
});
