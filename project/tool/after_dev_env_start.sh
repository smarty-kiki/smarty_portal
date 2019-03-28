#!/bin/bash

php /var/www/smarty_portal/public/cli.php migrate:install
php /var/www/smarty_portal/public/cli.php migrate

php /var/www/smarty_portal/public/cli.php account:add-admin --email=123@qq.com --password=123
