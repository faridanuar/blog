FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG dbuser
ARG dbpass
ARG dbname

# Set non-interactive environment
ENV DEBIAN_FRONTEND noninteractive

# Install system dependencies
RUN sudo apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-server \
    nginx \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install MariaDB
RUN service mariadb start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS $dbname;" && \
    mysql -e "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass';" && \
    mysql -e "GRANT ALL PRIVILEGES ON $dbname.* TO '$dbuser'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Install Nginx
COPY ./docker-compose/nginx/blog.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled

# Expose ports
EXPOSE 80

# Set working directory
WORKDIR /var/www/html

# Run composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# SWITCH to the USER for running Composer and Artisan Commands
USER $user

# Copy the Laravel project files into the image
COPY . /var/www/html/

# Create .env file (for flo server deployment)
RUN echo "\
    APP_NAME=blog\
    APP_ENV=local\
    APP_KEY=base64:kfznkW1ss6s5c8hCQsYyO/vCjHeFaDSTCqosqIh7dz4=\
    APP_DEBUG=true\
    APP_URL=http://blog\
    LOG_CHANNEL=stack\
    LOG_LEVEL=debug\
    DB_CONNECTION=mysql\
    DB_HOST=localhost\
    DB_PORT=3306\
    DB_DATABASE=blog\
    DB_USERNAME=root\
    DB_PASSWORD=\
    BROADCAST_DRIVER=log\
    CACHE_DRIVER=file\
    QUEUE_CONNECTION=sync\
    SESSION_DRIVER=file\
    SESSION_LIFETIME=120\
    MEMCACHED_HOST=127.0.0.1\
    REDIS_HOST=127.0.0.1\
    REDIS_PASSWORD=null\
    REDIS_PORT=6379\
    MAIL_MAILER=smtp\
    MAIL_HOST=mailhog\
    MAIL_PORT=1025\
    MAIL_USERNAME=null\
    MAIL_PASSWORD=null\
    MAIL_ENCRYPTION=null\
    MAIL_FROM_ADDRESS=null\
    MAIL_FROM_NAME='${APP_NAME}'\
    AWS_ACCESS_KEY_ID=\
    AWS_SECRET_ACCESS_KEY=\
    AWS_DEFAULT_REGION=us-east-1\
    AWS_BUCKET=\
    PUSHER_APP_ID=\
    PUSHER_APP_KEY=\
    PUSHER_APP_SECRET=\
    PUSHER_APP_CLUSTER=mt1\
    MIX_PUSHER_APP_KEY='${PUSHER_APP_KEY}'\
    MIX_PUSHER_APP_CLUSTER='${PUSHER_APP_CLUSTER}'\
    MAILCHIMP_KEY=\
    MAILCHIMP_LIST_SUBSCRIBERS=\
    " > /var/www/html/.env

# Debug output section when running dockerfile
#RUN chown -R $user:$user /var/www/html/
RUN composer --version
RUN ls -al /var/www/html/
RUN composer clear-cache

# Install dependencies and generate the optimized autoload files
RUN composer install --optimize-autoloader --verbose

# Run artisan migrate and seed
RUN php /var/www/html/artisan migrate --force
RUN php /var/www/html/artisan db:seed --force

# Start Nginx and PHP-FPM
CMD service php8.1-fpm start && nginx -g "daemon off;"
