FROM php:7.3-fpm

RUN apt update
RUN apt install
RUN docker-php-ext-install pdo pdo_mysql mysqli

CMD ["php-fpm"]
