FROM alpine:3.10
WORKDIR "/application"

ENV TERM=linux

ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
COPY 50-settings.ini /etc/php7/conf.d/50-settings.ini

RUN apk --update add ca-certificates curl icu-dev icu-libs libzip-dev autoconf git \
    && echo "@php https://dl.bintray.com/php-alpine/v3.10/php-7.4" >> /etc/apk/repositories \
    && apk --update add \
        php@php \
        php-curl@php \
        php-bcmath@php \
        php-ctype@php \
        php-dom@php \
        php-fpm@php \
        php-iconv@php \
        php-intl@php \
        php-mbstring@php \
        php-pcntl@php \
        php-posix@php \
        php-xdebug@php \
        php-xml@php \
        php-mongodb@php \
        php-sockets@php \
    && ln -s /usr/bin/php7 /usr/bin/php \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && mkdir -p /application/source/var \
    && chmod -R a+rwx /application/source/var

COPY www.conf /etc/php7/php-fpm.d/www.conf

CMD ["/usr/sbin/php-fpm7", "--nodaemonize"]
