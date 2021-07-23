FROM php:alpine

# RUN apk update && apk add curl nano git zip unzip

# Install Composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
&& curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
# Verify installer
&& php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
&& php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot \
&& rm -f /tmp/composer-setup.*

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk add libpng libpng-dev libjpeg-turbo-dev libwebp-dev zlib-dev libxpm-dev gd && docker-php-ext-install gd

RUN apk add libzip-dev zip

RUN docker-php-ext-install zip