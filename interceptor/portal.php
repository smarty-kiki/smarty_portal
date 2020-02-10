<?php

define('PORTAL_ACCOUNT_TOKEN_NAME', 'account_token');

function get_portal_account_info()
{/*{{{*/
    $config = config('portal');

    otherwise(! empty($config), '门户拦截器使用时需要有对应的配置');

    $domain = $config['domain'];
    $system_token = $config['system_token'];

    $url = url_transfer(uri(), function ($url_info) {

        unset($url_info['query'][PORTAL_ACCOUNT_TOKEN_NAME]);

        return $url_info;
    });

    $token = input(PORTAL_ACCOUNT_TOKEN_NAME);
    if (is_null($token)) {
        $token = cookie(PORTAL_ACCOUNT_TOKEN_NAME);
    }

    if (is_null($token)) {
        redirect($domain.'/login');
        trigger_redirect();
        exit;
    }

    $info = remote_get_json($domain.'/permission/query?'.http_build_query([
        'url' => $url,
        'system_token' => $system_token,
        'account_token' => $token,
    ]));

    if (! $info['authorized']) {

        redirect($domain.'/login');
        trigger_redirect();
        exit;
    }

    setcookie(PORTAL_ACCOUNT_TOKEN_NAME, $token, time() + 31536000);

    return $info;
}/*}}}*/
