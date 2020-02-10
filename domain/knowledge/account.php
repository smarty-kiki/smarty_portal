<?php

function account_login(account $account, $password)
{/*{{{*/
    $sign = $account->login(ip(), $password);

    setcookie('sign', $sign, time() + 31536000);
}/*}}}*/

function get_logined_account()
{/*{{{*/
    $sign = cookie_safe('sign');

    if (is_null($sign)) {
        redirect('/login?refer='.uri());
        trigger_redirect();
        exit;
    }

    $account = dao('account')->find_by_sign_and_valid($sign);
    if ($account->is_null()) {
        redirect('/login?refer='.uri());
        trigger_redirect();
        exit;
    }

    return $account;
}/*}}}*/
