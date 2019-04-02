#!/bin/bash

ROOT_DIR="$(cd "$(dirname $0)" && pwd)"/../..

ln -fs $ROOT_DIR/project/config/production/nginx/smarty_portal.conf /etc/nginx/sites-enabled/smarty_portal
/usr/sbin/service nginx reload

/bin/bash $ROOT_DIR/project/tool/dep_build.sh link
/usr/bin/php $ROOT_DIR/public/cli.php migrate

chown -R www-data:www-data /var/www/smarty_portal/view/blade
rm -rf /var/www/smarty_portal/view/blade/*.php
