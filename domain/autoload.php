<?php

spl_autoload_register(function ($class_name) {

    $class_maps = array(
        'url_permission_tag_dao' => 'dao/url_permission_tag.php',
        'account_dao' => 'dao/account.php',
        'system_dao' => 'dao/system.php',
        'url_dao' => 'dao/url.php',
        'menu_dao' => 'dao/menu.php',
        'account_permission_tag_dao' => 'dao/account_permission_tag.php',
        'permission_tag_dao' => 'dao/permission_tag.php',
        'url_permission_tag' => 'entity/url_permission_tag.php',
        'account' => 'entity/account.php',
        'system' => 'entity/system.php',
        'url' => 'entity/url.php',
        'menu' => 'entity/menu.php',
        'account_permission_tag' => 'entity/account_permission_tag.php',
        'permission_tag' => 'entity/permission_tag.php',
    );

    if (isset($class_maps[$class_name])) {
         include __DIR__.'/'.$class_maps[$class_name];
    }
});
