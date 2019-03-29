<?php

define('PORTAL_DOMAIN', 'http://portal.yao-yang.cn');
define('PORTAL_SYSTEM_TOKEN', '5a07080039ff22b36134e6bf1977c6bd');

command('portal:permission-regist', '权限注册', function ()
{
    $config_yml ='
name: 数字货币
token: '.PORTAL_SYSTEM_TOKEN.'
menus:
      - name: 分析
        permission_tags:
        menus:
            - name: 看板
              url: http://coin.yao-yang.cn/
              permission_tags:
                    - coin_analysis
';

    $receive_token = remote_post(PORTAL_DOMAIN.'/permission/rewrite', $config_yml);
    if ($receive_token !== PORTAL_SYSTEM_TOKEN) {
        die('设置了不匹配的系统');
    }
});
