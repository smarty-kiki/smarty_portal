<?php

function get_portal_account_info()
{/*{{{*/
    $config = config('portal');
    $domain = $config['domain'];
    $system_token = $config['system_token'];

    $url = uri();
    $token = input('account_token');

    $info = remote_get_json($domain.'/permission/query?'.http_build_query([
        'url' => $url,
        'system_token' => $system_token,
        'account_token' => $token,
    ]));

    if (! $info['authorized']) {

        redirect($domain.'/login');
        exit;
    }

    return $info;
}/*}}}*/
