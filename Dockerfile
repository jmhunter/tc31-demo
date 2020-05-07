FROM php:apache

RUN apt-get update && \
    apt-get -y install vim && \
    docker-php-ext-install mysqli


#    apt-get -y install openssl libssl-dev libcurl4-openssl-dev composer && \
#    pecl install mongodb && \
#    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini && \
#    cd /var/www/html && \
#    composer require mongodb/mongodb

COPY html /var/www/html
