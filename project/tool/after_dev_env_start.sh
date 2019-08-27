#!/bin/bash

ENV=development php /var/www/smarty_portal/public/cli.php migrate:install
ENV=development php /var/www/smarty_portal/public/cli.php migrate

ENV=development php /var/www/smarty_portal/public/cli.php seed
