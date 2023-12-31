# Use an official PHP Apache image as the base
FROM php:8.1-apache

USER root

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG dbuser
ARG dbpass
ARG dbname

# Expose ports
#EXPOSE 9000 80 443

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html/

# Create log dir
RUN mkdir /var/www/log

# Set file permission so have access from browser
RUN chown -R www-data:www-data /var/www/html

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    git \
    curl \
    cron \
    mariadb-server \
    zip \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install PHP extensions required by your application
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install MariaDB & Create Databse for app
RUN service mariadb start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS $dbname;" && \
    mysql -e "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass';" && \
    mysql -e "GRANT ALL PRIVILEGES ON $dbname.* TO '$dbuser'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Create .env file (for flo server deployment)
RUN echo "\
    APP_NAME='blog'\n\
    APP_ENV='staging'\n\
    APP_KEY='base64:kfznkW1ss6s5c8hCQsYyO/vCjHeFaDSTCqosqIh7dz4='\n\
    APP_DEBUG=true\n\
    APP_URL=localhost\n\
    LOG_CHANNEL=stack\n\
    LOG_LEVEL=debug\n\
    DB_CONNECTION=mysql\n\
    DB_HOST=localhost\n\
    DB_PORT=3306\n\
    DB_DATABASE=blog\n\
    DB_USERNAME=farid\n\
    DB_PASSWORD=secret\n\
    BROADCAST_DRIVER=log\n\
    CACHE_DRIVER=file\n\
    QUEUE_CONNECTION=sync\n\
    SESSION_DRIVER=file\n\
    SESSION_LIFETIME=120\n\
    MEMCACHED_HOST=127.0.0.1\n\
    REDIS_HOST=127.0.0.1\n\
    REDIS_PASSWORD=null\n\
    REDIS_PORT=6379\n\
    MAIL_MAILER=smtp\n\
    MAIL_HOST=mailhog\n\
    MAIL_PORT=1025\n\
    MAIL_USERNAME=null\n\
    MAIL_PASSWORD=null\n\
    MAIL_ENCRYPTION=null\n\
    MAIL_FROM_ADDRESS=null\n\
    MAIL_FROM_NAME='${APP_NAME}'\n\
    AWS_ACCESS_KEY_ID=\n\
    AWS_SECRET_ACCESS_KEY=\n\
    AWS_DEFAULT_REGION=us-east-1\n\
    AWS_BUCKET=\n\
    PUSHER_APP_ID=\n\
    PUSHER_APP_KEY=\n\
    PUSHER_APP_SECRET=\n\
    PUSHER_APP_CLUSTER=mt1\n\
    MIX_PUSHER_APP_KEY='${PUSHER_APP_KEY}'\n\
    MIX_PUSHER_APP_CLUSTER='${PUSHER_APP_CLUSTER}'\n\
    MAILCHIMP_KEY=\n\
    MAILCHIMP_LIST_SUBSCRIBERS=\n\
    " > /var/www/html/.env

# SWITCH to the USER for running Composer and Artisan Commands
#USER $user

# Debug output section when running dockerfile
#RUN chown -R $user:$user /var/www/html/
#RUN composer --version
#RUN ls -al /var/www/html/
#RUN composer clear-cache

# Install application dependencies using Composer
RUN composer install --no-interaction --optimize-autoloader

# Run artisan migrate and seed
RUN php /var/www/html/artisan migrate --force --env=staging
RUN php /var/www/html/artisan db:seed --force --env=staging

RUN php artisan storage:link

#USER root

# Check Apache2 files
RUN ls /etc/apache2/sites-available

# Check Laravel files
RUN ls /var/www/html/storage

# Set up Apache virtual host
COPY docker-compose/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Enable apache modules
RUN a2enmod rewrite
#RUN a2enmod ssl

# Start Apache server
CMD ["apache2-foreground"]
