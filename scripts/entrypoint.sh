#!/bin/bash
set -e

cd /var/www/html

# Garante que o banco SQLite existe
mkdir -p database
[ -f database/database.sqlite ] || touch database/database.sqlite

# Configura permissões
chown -R www-data:www-data storage bootstrap/cache database

# Gera APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Executa migrations
php artisan migrate --force

# Inicia o Supervisor (que gerencia nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
