#!/bin/sh

echo "🎬 entrypoint.sh: [$(whoami)] [PHP $(php -r 'echo phpversion();')]"

php artisan cache:clear
php artisan config:clear
php artisan clear
composer dump-autoload --no-interaction --no-dev --optimize

echo "☕ run npm install"
npm install && npm run build

echo "🎬 artisan commands"

# 💡 Group into a custom command e.g. php artisan app:on-deploy
php artisan migrate --no-interaction --force
php artisan storage:link

echo "🎬 start supervisord"

supervisord -c $LARAVEL_PATH/.deploy/config/supervisor.conf
