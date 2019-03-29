<?php

if_post('/permission/rewrite', function ()
{
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
});
