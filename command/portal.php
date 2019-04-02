<?php

command('portal:permission-regist', '权限注册', function ()
{
    $config = config('portal');
    $system_token = $config['system_token'];

    $config_yml ='
name: 数字货币
token: '.$system_token.'
menus:
      - name: 分析
        permission_tags:
        menus:
            - name: 看板
              url: http://coin.yao-yang.cn/
              permission_tags:
                    - coin_analysis
';

    $receive_token = remote_post($config['domain'].'/permission/rewrite', $config_yml);
    if ($receive_token === $system_token) {
        die('设置成功');
    }
});
