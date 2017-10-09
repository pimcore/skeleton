FROM phpdockerio/php71-fpm:latest

# Install PHP
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.1-mbstring php7.1-mysql php-redis php7.1-bcmath php7.1-bz2 php7.1-gd php7.1-imap php-imagick php7.1-intl php7.1-ldap php7.1-soap php-ssh2 php7.1-xmlrpc php7.1-xsl php-yaml php-xhprof php-xdebug

# Pimcore Stuff
RUN apt-get -y --no-install-recommends install ffmpeg html2text ghostscript libreoffice pngcrush jpegoptim exiftool poppler-utils git wget

# Install Build Tools (getting removed later)
RUN apt-get -y --no-install-recommends install autoconf automake libtool nasm make pkg-config libz-dev build-essential g++

RUN cd ~

RUN wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz \
       && tar xvf wkhtmltox-0.12.4_linux-generic-amd64.tar.xz \
       && mv wkhtmltox/bin/wkhtmlto* /usr/bin/

# Install Mozjpeg
RUN git clone https://github.com/mozilla/mozjpeg.git  \
        && cd mozjpeg \
        && autoreconf -fiv \
        && ./configure \
        && make \
        && make install \
        && ln -s /opt/mozjpeg/bin/cjpeg /usr/bin/cjpeg \
        && cd .. \
        && rm -rf mozjpeg

# Install Zopflipng
RUN git clone https://github.com/google/zopfli.git \
        && cd zopfli \
        && make \
        && cp zopfli /usr/bin/zopflipng \
        && cd .. \
        && rm -rf zopfli

# Install Pngout
RUN wget http://static.jonof.id.au/dl/kenutils/pngout-20150319-linux.tar.gz \
        && tar -xf pngout-20150319-linux.tar.gz \
        && rm pngout-20150319-linux.tar.gz \
        && cp pngout-20150319-linux/x86_64/pngout /bin/pngout \
        && cd .. \
        && rm -rf pngout-20150319-linux

# Install advpng
RUN wget http://prdownloads.sourceforge.net/advancemame/advancecomp-1.17.tar.gz \
        && tar zxvf advancecomp-1.17.tar.gz \
        && cd advancecomp-1.17 \
        && ./configure \
        && make \
        && make install \
        && cd .. \
        && rm -rf advancecomp-1.17

# Cleanup
RUN apt-get remove -y autoconf automake libtool nasm make pkg-config libz-dev build-essential g++ \
        && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN echo "xdebug.idekey = PHPSTORM" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.default_enable = 1" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_enable = 1" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_autostart = 1" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_connect_back = 0" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.profiler_enable = 0" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini && \
    echo "xdebug.remote_host = 127.0.0.1" >> /etc/php/7.1/fpm/conf.d/20-xdebug.ini

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
WORKDIR "/application"