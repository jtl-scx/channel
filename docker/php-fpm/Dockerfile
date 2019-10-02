FROM alpine:3.9
WORKDIR "/application"

ENV TERM=linux

ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
COPY 50-settings.ini /etc/php7/conf.d/50-settings.ini

RUN apk --update add ca-certificates curl icu-dev icu-libs libzip-dev autoconf git \
    && echo "@php https://dl.bintray.com/php-alpine/v3.9/php-7.3" >> /etc/apk/repositories \
    && apk --update add \
        php@php \
        php-bcmath@php \
        php-ctype@php \
        php-dom@php \
        php-fpm@php \
        php-iconv@php \
        php-intl@php \
        php-mbstring@php \
        php-openssl@php \
        php-pcntl@php \
        php-posix@php \
        php-pgsql@php \
        php-redis@php \
        php-sockets@php \
        php-xdebug@php \
        php-xml@php \
        php-zip@php \
        php-zlib@php \
    && ln -s /usr/bin/php7 /usr/bin/php \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* /usr/share/doc/*

CMD ["/usr/sbin/php-fpm7", "--nodaemonize"]