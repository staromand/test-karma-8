FROM php:8.1.9-fpm

#php-modules
RUN set -ex \
   && apt-get update && apt-get install -y \
   libfreetype6-dev \
   libonig-dev \
   libicu-dev \
   libjpeg-dev \
   libmcrypt-dev \
   libpng-dev \
   libzip-dev \
   libxml2-dev \
   libmemcached-dev \
   libz-dev \
   unzip \
   graphviz \
   git \
   gnupg \
   wget \
   mc \
   nano \
   supervisor \
   && docker-php-ext-install bcmath calendar iconv intl mbstring mysqli opcache pcntl pdo pdo_mysql soap sockets sysvmsg sysvsem sysvshm xml zip

   #composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
   && php composer-setup.php --install-dir=/usr/bin --version=1.10.20 \
   && php -r "unlink('composer-setup.php');" \
   && ln -s /usr/bin/composer.phar /usr/bin/composer \
   && chmod +x /usr/bin/composer.phar

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

RUN composer self-update --2

RUN apt-get update && apt-get install -y software-properties-common ca-certificates apt-transport-https lsb-release

RUN pecl install xdebug

RUN echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20210902/xdebug.so' | tee /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log_level=0" | tee -a /usr/local/etc/php/conf.d/xdebug.ini

RUN set -x ; \
deluser www-data ; \
delgroup www-data ; \
addgroup --gid 82 --system www-data ; \
adduser --uid 82 --disabled-login --system --ingroup www-data www-data && exit 0 ; exit 1

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN printf "[PHP]\ndate.timezone = \"$TZ\"\n" > /usr/local/etc/php/conf.d/tzone.ini

WORKDIR /var/www

CMD ["php-fpm"]
