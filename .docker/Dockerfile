FROM pimcore/pimcore:php8.3-v3 AS base
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
COPY --chown=www-data:www-data / /var/www/html
RUN --mount=type=secret,id=kernel-secret,uid=1000 \
	set -eux; \
	cd /var/www/html; \
    runuser -u www-data -- php /usr/local/bin/composer install; \
    runuser -u www-data -- /var/www/html/bin/console pimcore:build:classes; \
    runuser -u www-data -- /var/www/html/bin/console cache:warmup

FROM base AS init
# TODO allow for custom bundles to be passed via args?
COPY /.docker/init/init.sh /init.sh
CMD [ "/init.sh" ]

FROM base AS php
RUN set -eux; \
    apt-get update -y; \
    apt-get install -y --no-install-recommends nginx; \
    rm -rf /var/lib/apt/lists/*;
COPY /.docker/php/php.ini /usr/local/etc/php/conf.d/docker-pimcore-php.ini
COPY /.docker/php/nginx.conf /etc/nginx/sites-available/default
COPY /.docker/php/supervisord.conf /etc/supervisor/supervisord.conf
CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf" ]

FROM base AS supervisord
COPY --from=pimcore/pimcore:php8.3-supervisord-v3 /var/run /var/run
COPY --from=pimcore/pimcore:php8.3-supervisord-v3 /usr/sbin/cron /usr/sbin/cron
COPY --from=pimcore/pimcore:php8.3-supervisord-v3 /etc/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY /.docker/supervisord/supervisord.conf /etc/supervisor/conf.d/pimcore.conf
CMD [ "/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/pimcore.conf" ]

FROM base AS php-debug
COPY --from=pimcore/pimcore:php8.3-debug-v3 /usr/local/bin/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug;
ENV PHP_IDE_CONFIG serverName=localhost
COPY /.docker/php-debug/xdebug.conf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
