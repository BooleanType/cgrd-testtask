#!/bin/bash
set -e

cd /var/www/html

if [ ! -d "vendor" ]; then
  composer install --prefer-dist --no-scripts --no-progress --no-dev --optimize-autoloader
fi

exec apache2-foreground

