# syntax=docker/dockerfile:1

FROM pimcore/pimcore:php8.4-v4 AS base
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends autoconf make g++ unixodbc-dev cron procps iputils-ping vim supervisor netcat-traditional default-mysql-client; \
    rm -rf /var/lib/apt/lists/*; \
    usermod -u 1000 www-data; \
    groupmod -g 1000 www-data;
# We copy in the composer files and download dependencies, then in a separate set of statements below copy in the full
# source directory and run a full composer install. This will take advantage of Docker-build caching when the composer
# dependencies do not change.
COPY --chown=www-data:www-data /composer.* /var/www/html
COPY /.docker/composer-install-dependencies.sh /composer-install-dependencies.sh
RUN /composer-install-dependencies.sh
COPY /.docker/secrets-to-env-vars.sh /etc/profile.d/secrets-to-env-vars.sh
COPY --chown=www-data:www-data / /var/www/html
RUN --mount=type=secret,id=kernel-secret,uid=1000 \
    # These three secrets are deliberately mounted as env vars rather than files as required by Pimcore
    --mount=type=secret,id=pimcore-product-key,env=PIMCORE_PRODUCT_KEY,uid=1000 \
    --mount=type=secret,id=pimcore-instance-identifier,env=PIMCORE_INSTANCE_IDENTIFIER,uid=1000 \
    --mount=type=secret,id=pimcore-encryption-secret,env=PIMCORE_ENCRYPTION_SECRET,uid=1000 \
        set -eux; \
        cd /var/www/html; \
        runuser -u www-data -- php /usr/local/bin/composer install; \
        runuser -u www-data -- /var/www/html/bin/console pimcore:build:classes; \
        runuser -u www-data -- /var/www/html/bin/console cache:warmup

FROM base AS init
COPY ./.docker/init/install-bundles.sh /install-bundles.sh
COPY /.docker/init/init.sh /init.sh
CMD [ "/init.sh" ]

FROM base AS php
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends nginx wget; \
    rm -rf /var/lib/apt/lists/*;
COPY /.docker/php/php.ini /usr/local/etc/php/conf.d/docker-pimcore-php.ini
COPY /.docker/php/nginx.conf /etc/nginx/sites-available/default
COPY /.docker/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./.docker/php/start-php.sh /start-php.sh
CMD [ "/start-php.sh" ]

FROM base AS supervisord
COPY --from=pimcore/pimcore:php8.4-supervisord-v4 /var/run /var/run
COPY --from=pimcore/pimcore:php8.4-supervisord-v4 /usr/sbin/cron /usr/sbin/cron
COPY /.docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./.docker/supervisord/start-supervisord.sh /start-supervisord.sh
CMD [ "/start-supervisord.sh" ]

FROM base AS php-debug
COPY --from=pimcore/pimcore:php8.4-debug-v4 /usr/local/bin/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug;
ENV PHP_IDE_CONFIG=serverName=localhost
COPY /.docker/php-debug/xdebug.conf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY /.docker/php-debug/start-php-debug.sh /start-php-debug.sh
CMD [ "/start-php-debug.sh" ]
