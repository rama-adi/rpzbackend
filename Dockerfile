FROM docker.io/bitnami/laravel:10
COPY . .
RUN composer install
RUN php artisan migrate
CMD php artisan serve --host=0.0.0.0
EXPOSE 443
