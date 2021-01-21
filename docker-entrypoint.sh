#!/bin/bash
set -e

function get_time() {
   echo "$(date '+%D %T')"
}

function runcmd() {
  echo "$(get_time). Running command: $1"
  $1
}

ENVIRONMENT=${ENVIRONMENT:-production}

if [ "$1" == "backend" ]; then

  if [ "${ENVIRONMENT}" == "DEVELOPMENT" ]; then
    runcmd "composer install"
  fi
  runcmd "chmod  public/images"
  runcmd "php database/migrate.php"

  echo "Running php-fpm"
  runcmd "exec php-fpm"

elif [ "$1" == "nginx" ]; then

  echo "Preparing configuration for nginx (${ENVIRONMENT})..."
  cat << EOF > /etc/nginx/conf.d/default.conf
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root ${BASE_PATH}/public;
    location ~ \.php\$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)\$;
        fastcgi_pass backend:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param PATH_INFO \$fastcgi_path_info;
    }
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
        gzip_static on;
    }
}
EOF

  echo "Running nginx (${ENVIRONMENT})..."
  exec nginx -g "daemon off;"
fi
