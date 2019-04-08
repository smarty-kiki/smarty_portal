<?php

function get_portal_account_info()
{/*{{{*/
    $config = config('portal');

    otherwise(! empty($config), '门户拦截器使用时需要有对应的配置');

    $domain = $config['domain'];
    $system_token = $config['system_token'];

    $url = uri();
    $url_info = parse_url($url);
    parse_str($url_info['query'], $query_info);
    unset($query_info['account_token']);
    $url_info['query'] = http_build_query($query_info);

    $url = unparse_url($url_info);

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
