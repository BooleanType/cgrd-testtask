# docker compose up -d --build

FROM php:8.4-apache

RUN a2enmod rewrite

# Copy virtual host config.
COPY ./docker/php/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN set -eu; \
    apt-get update -y && apt-get upgrade -y \
    && apt install -y --no-install-recommends \
        git\
        zip \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && rm -rf /tmp/* \
    && rm -rf /var/tmp/* \
    && rm -rf /var/list/apt/* \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean \
    && apt-get autoremove -y

# Get latest Composer.
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html/

COPY ./composer.json ./composer.lock ./
RUN composer install --prefer-dist --no-scripts --no-progress --no-dev --optimize-autoloader
COPY . .
RUN composer dump-autoload --optimize

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
