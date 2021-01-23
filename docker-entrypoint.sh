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
  runcmd "php database/migrate.php"

  echo "Running php-fpm"
  runcmd "exec php-fpm"

  echo "Running nginx (${ENVIRONMENT})..."
  exec nginx -g "daemon off;"
fi
