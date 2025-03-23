
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libsqlite3-dev \
    curl \
    && docker-php-ext-install pdo pdo_sqlite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy files
WORKDIR /var/www/html
COPY . .

# Install Composer and NPM packages
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Configure Laravel
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan migrate:fresh --seed

# Configure Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database 

CMD ["apache2-foreground"]
