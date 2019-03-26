<?php

spl_autoload_register(function ($class_name) {

    $class_maps = array(
        'account_dao' => 'dao/account.php',
        'system_dao' => 'dao/system.php',
        'menu_dao' => 'dao/menu.php',
        'account_permission_tag_dao' => 'dao/account_permission_tag.php',
        'permission_tag_dao' => 'dao/permission_tag.php',
        'menu_permission_tag_dao' => 'dao/menu_permission_tag.php',
        'account' => 'entity/account.php',
        'system' => 'entity/system.php',
        'menu' => 'entity/menu.php',
        'account_permission_tag' => 'entity/account_permission_tag.php',
        'permission_tag' => 'entity/permission_tag.php',
        'menu_permission_tag' => 'entity/menu_permission_tag.php',
    );

    if (isset($class_maps[$class_name])) {
         include __DIR__.'/'.$class_maps[$class_name];
    }
});
