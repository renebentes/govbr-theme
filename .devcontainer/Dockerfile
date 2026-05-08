FROM php:8.3-apache

# Install dependencies
RUN set -eux; \
    apt-get update; \
    apt-get install -y \
    # System goodies
    htop \
    mc \
    ssl-cert \
    # Needed for the zst Joomla package
    zstd \
    # PHP extensions dependencies
    libgd-dev \
    libldap2-dev \
    libonig-dev \
    libzip-dev \
    # MariaDB Client
    mariadb-client \
    ; \
    # Install the required PHP extensions for Zip and MySQL
    docker-php-ext-install zip \
    mysqli \
    gd \
    ldap \
    ; \
    apt-get clean \
    ; \
    rm -rf /var/lib/apt/lists/*

# Define Joomla version and expected SHA512 signature
ENV JOOMLA_VERSION="6.1.0"
ENV JOOMLA_SHA512="dec284382f1a23ab9412292400d94d3037f67923d5e51a1b51a25c63fb0045dfb1f5f5f96538e652f54ea6d28ea7ed9b590ba9016fa051e45393b1ce54da3e1b"
ENV JOOMLA_URL="https://github.com/joomla/joomla-cms/releases/download/$JOOMLA_VERSION/Joomla_$JOOMLA_VERSION-Stable-Full_Package.tar.zst"

# Download package and extract to web volume
RUN set -eux; \
    curl -o joomla.tar.zst -fsSL $JOOMLA_URL; \
    echo "$JOOMLA_SHA512 *joomla.tar.zst" | sha512sum -c -; \
    tar --zstd -xf joomla.tar.zst -C /var/www/html; \
    rm joomla.tar.zst; \
    chown -R www-data:www-data /var/www/html

# Install composer
RUN set -eux; \
    curl -fsSL https://getcomposer.org/installer | php ;\
    chmod +x composer.phar; \
    mv composer.phar /usr/local/bin/composer

# Install Xdebug
RUN set -eux; \
    yes | pecl install xdebug \
    ; \
    echo "zend_extension = $(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.client_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini; \
    echo "xdebug.client_host = localhost" >> /usr/local/etc/php/conf.d/xdebug.ini \
    ; \
    rm -rf /tmp/pear \
    ; \
    echo "upload_tmp_dir = /tmp" > /usr/local/etc/php/conf.d/custom-php.ini; \
    echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/custom-php.ini; \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/custom-php.ini; \
    echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/custom-php.ini; \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/custom-php.ini; \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/custom-php.ini
