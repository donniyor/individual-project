# Use the base image
FROM yiisoftware/yii-php:8.1-fpm-nginx

# Set the working directory
WORKDIR /app/public

# Copy the application code into the container
COPY . .

RUN apt-get update \
    && apt-get install -y curl git zip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype

# Run composer install and cleanup in a single step to reduce layers
RUN composer update --no-interaction \
    && composer install --no-interaction

# Create directories for runtime and assets with correct permissions
RUN chown -R www-data:www-data /app/public

# Expose port 80
EXPOSE 80
