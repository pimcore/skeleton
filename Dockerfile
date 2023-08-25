FROM pimcore/pimcore:PHP8.2-fpm

# Install NGINX
RUN apt-get update
RUN apt-get install -y nginx

RUN sed -i 's/memory_limit\ = 256M/memory_limit\ = 8192M/g' /usr/local/etc/php/conf.d/20-pimcore.ini

# Add Configuration for NGINX
COPY site.conf /etc/nginx/conf.d/

# Install Supervisord
RUN apt-get install -y supervisor

# Add Configuration for Supervisord
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add Application specific files
COPY . /var/www/html

## Create the log file to be able to run tail
RUN touch /var/www/html/var/nginx.status
RUN touch /var/www/html/var/nginx.err
RUN touch /var/www/html/var/fpm.status
RUN touch /var/www/html/var/fpm.err

# Pimcore Project Setup
RUN cd /var/www/html && COMPOSER_MEMORY_LIMIT=-1 composer update
RUN cd /var/www/html && chmod -Rf 0777 bin/ && ./bin/console assets:install public
RUN ./bin/console pimcore:bundle:install PimcoreDataImporterBundle
RUN cd /var/www/html && chmod -Rf 0777 var/ public/ vendor/pimcore/ var/classes/ var/log/
RUN chown -R www-data:www-data /var/*


#CMD php-fpm && service start nginx

# Setup cron job

#RUN (crontab -l ; echo "* * * * * /usr/local/bin/php /var/www/html/bin/console process-manager:maintenance") | crontab
#RUN (crontab -l ; echo "0 0 * * * /usr/local/bin/php /var/www/html/bin/console pimcore:maintenance --async") | crontab

EXPOSE 8080

# Start Supervisor
CMD ["/usr/bin/supervisord"]