FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite
WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN cp .env.example .env
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan key:generate
RUN php artisan migrate:fresh --seed
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
CMD ["apache2-foreground"]