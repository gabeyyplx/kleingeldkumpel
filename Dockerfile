FROM php:8.4-apache

RUN a2enmod rewrite
RUN apt-get update && apt-get install -y \
    git curl zip unzip sqlite3 libsqlite3-dev libicu-dev \
    && docker-php-ext-install pdo pdo_sqlite opcache intl \
    && rm -rf /var/lib/apt/lists/*

RUN git config --global --add safe.directory /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html
RUN php bin/console asset-map:compile

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]