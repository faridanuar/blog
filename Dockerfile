# Use an official PHP Apache image as the base
FROM php:8.1-apache

USER root

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG dbuser
ARG dbpass
ARG dbname

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html/

# Create log dir
RUN mkdir /var/www/log

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    git \
    curl \
    mariadb-server \
    zip \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
    APP_ENV='local'\n\
    APP_KEY='base64:kfznkW1ss6s5c8hCQsYyO/vCjHeFaDSTCqosqIh7dz4='\n\
    APP_DEBUG=true\n\
    APP_URL='https://blog-dev-xffj.2.sg-1.fl0.io'\n\
    LOG_CHANNEL=stack\n\
    LOG_LEVEL=debug\n\
    DB_CONNECTION=mysql\n\
    DB_HOST=localhost\n\
    DB_PORT=3306\n\
    DB_DATABASE=blog\n\
    DB_USERNAME=root\n\
    DB_PASSWORD=\n\
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
USER $user

# Debug output section when running dockerfile
#RUN chown -R $user:$user /var/www/html/
RUN composer --version
RUN ls -al /var/www/html/
RUN composer clear-cache

# Install application dependencies using Composer
RUN composer install --no-interaction --optimize-autoloader

# Run artisan migrate and seed
RUN php /var/www/html/artisan migrate --force
RUN php /var/www/html/artisan db:seed --force

USER root

# Expose ports
EXPOSE 9000 80 443

# Set file permission so have access from browser
RUN chown -R www-data:www-data /var/www/html

# Set up Apache virtual host
COPY docker-compose/apache/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite apache.conf
RUN a2enmod rewrite

# Start Apache server
CMD ["apache2-foreground"]
