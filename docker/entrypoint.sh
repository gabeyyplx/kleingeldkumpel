#!/bin/sh
set -e

echo "Running app setup..."
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:setup 

echo "Starting Apache..."
exec apache2-foreground
