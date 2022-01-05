FROM php:8.1-cli-alpine

RUN \
    # Use the default production configuration
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    # Xdebug extension
    mkdir -p /usr/src/php/ext/xdebug && \
    curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 && \
    docker-php-ext-install xdebug && \
    rm -rf /usr/src/php/ext/xdebug && \
    rm $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer
