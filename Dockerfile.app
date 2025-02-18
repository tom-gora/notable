FROM docker.io/library/php:8.3.14-fpm

# Change base PHP config
RUN sed -i 's/upload_max_filesize = .*M/upload_max_filesize = 50M/' /usr/local/etc/php/php.ini-production && \
    sed -i 's/post_max_size = .*M/post_max_size = 50M/' /usr/local/etc/php/php.ini-production && \
    sed -i 's/max_execution_time = .*/max_execution_time = 120/' /usr/local/etc/php/php.ini-production && \
    sed -i 's/memory_limit = .*M/memory_limit = 200M/' /usr/local/etc/php/php.ini-production && \
    mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install dependencies
RUN apt-get update && \
    apt-get install -y --no-install-recommends --quiet \
    build-essential \
    libfreetype6-dev \
    libpq-dev \
    libjpeg-dev \
    libwebp-dev \
    libxpm-dev \
    libmagickwand-dev \
    libpng-dev \
    libzip-dev \
    brotli \
    libtidy-dev \
    libmemcached-dev \
    netcat-openbsd \
    sudo \
    tidy \
    zip \
    unzip \
    libmcrypt-dev \
    libonig-dev \
    imagemagick \
    nodejs \
    npm && \
    rm -rf /var/lib/apt/lists/*

# Install Imagick extension
RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/3.7.0.tar.gz && \
    mkdir -p /usr/src/imagick && \
    tar --strip-components=1 -xf /tmp/imagick.tar.gz -C /usr/src/imagick && \
    cd /usr/src/imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini && \
    cd / && \
    rm -rf /usr/src/imagick /tmp/imagick.tar.gz


    # Enable PHP extensions
RUN docker-php-ext-enable imagick
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    opcache \
    tidy \
    intl

# Set the working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Set the required user
RUN adduser --disabled-password --gecos "" notableuser && \
echo "notableuser ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/notableuser && \
chmod 0440 /etc/sudoers.d/notableuser && \
chown -R notableuser:notableuser /var/www/html

USER notableuser
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod +x /var/www/html/notable-entrypoint
# run migrations, optimisations and all other deployment artisan crap
# script while loops to wait until DB is 100% up to avoid delay breaking migrations
ENTRYPOINT ["/var/www/html/notable-entrypoint"]

CMD ["php-fpm"]


