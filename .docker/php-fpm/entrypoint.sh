#!/bin/bash

# xdebug config
if [ -f /etc/php/7.1/fpm/conf.d/20-xdebug.ini ]
then
    # if XDEBUG_HOST is manually set
    HOST="$XDEBUG_HOST"

    # else if check if is Docker for Mac
    if [ -z "$HOST" ]; then
        HOST=`getent hosts docker.for.mac.localhost | awk '{ print $1 }'`
    fi

    # else get host ip
    if [ -z "$HOST" ]; then
        HOST=`/sbin/ip route|awk '/default/ { print $3 }'`
    fi

    sed -i "s/xdebug\.remote_host \=.*/xdebug\.remote_host\=$HOST/g" /etc/php/7.1/fpm/conf.d/20-xdebug.ini
fi

exec $@