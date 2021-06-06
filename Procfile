web: vendor/bin/heroku-php-nginx -C nginx.conf public/
release: php artisan migrate --force --seed
worker: php artisan queue:work