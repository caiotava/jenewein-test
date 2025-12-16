FROM dunglas/frankenphp:1.10-php8.5

WORKDIR /app

COPY bin ./bin
COPY config ./config
COPY public ./public
COPY migrations ./migrations
COPY src ./src
COPY composer.json composer.lock symfony.lock Caddyfile .env ./
COPY example.db ./var/data_prod.db

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    zip

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm -f /var/log/lastlog /var/log/faillog

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php bin/console cache:clear
RUN php bin/console lexik:jwt:generate-keypair --overwrite

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]