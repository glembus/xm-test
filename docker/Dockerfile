# syntax=docker/dockerfile:1
FROM laradock/php-fpm:latest-8.1

#COPY ./001-test.conf /etc/apache2/sites-available/001-test.conf

RUN apt update  \
    && cd ~  \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php  \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer -q \
    && rm composer-setup.php \
    && apt install git nodejs npm zlib1g-dev libzip-dev unzip -y -q \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

ARG INSTALL_XDEBUG=true
ARG XDEBUG_PORT=9003

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  pecl install xdebug-3.1.4 \
  && docker-php-ext-enable xdebug \
;fi

# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_host=/xdebug.client_host=/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_connect_back=0/xdebug.discover_client_host=false/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_port=9000/xdebug.client_port=${XDEBUG_PORT}/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.profiler_enable=0/; xdebug.profiler_enable=0/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.profiler_output_dir=/xdebug.output_dir=/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_mode=req/; xdebug.remote_mode=req/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_autostart=0/xdebug.start_with_request=yes/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_enable=0/xdebug.mode=debug/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

#RUN if [ ${INSTALL_XDEBUG} = true ]; then \
#    apt-get install -yqq --force-yes php8.1-phpdbg \
#;fi
