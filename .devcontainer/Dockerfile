ARG VARIANT=5.4-php8.2-apache
FROM joomla:${VARIANT}

# Install goodies
RUN apt-get update; \
    apt-get install -y mc htop

# Install composer
RUN curl -sSL https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

# Install Xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension = $(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode = develop" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request = trigger" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && rm -rf /tmp/pear
