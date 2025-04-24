ARG VARIANT=5.2-php8.2-apache
FROM joomla:${VARIANT}

# Install composer
RUN curl -sSL https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer
