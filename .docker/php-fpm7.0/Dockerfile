FROM phpdockerio/php7-fpm:latest

RUN apt-get update
RUN echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list
RUN apt-get -y --no-install-recommends install apt-transport-https
RUN curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN apt-get update

# Install PHP
RUN apt-get -y --no-install-recommends install  php7.0-mbstring php7.0-memcached php7.0-mysql php7.0-redis php7.0-bcmath php7.0-bz2 php7.0-gd php7.0-imap php7.0-imagick php7.0-intl php7.0-ldap php7.0-soap php7.0-ssh2 php7.0-xmlrpc php7.0-xsl php7.0-xdebug

# Pimcore Stuff
RUN apt-get -y --no-install-recommends install wkhtmltopdf html2text ghostscript libreoffice pngcrush jpegoptim exiftool poppler-utils git wget

# Install Build Tools (getting removed later)
RUN apt-get -y --no-install-recommends install autoconf automake libtool nasm make pkg-config libz-dev build-essential g++

RUN cd ~

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

WORKDIR "/application"