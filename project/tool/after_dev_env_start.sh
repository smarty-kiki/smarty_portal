#!/bin/bash

php /var/www/smarty_portal/public/cli.php migrate:install
php /var/www/smarty_portal/public/cli.php migrate

php /var/www/smarty_portal/public/cli.php seed
