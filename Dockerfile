FROM php:8.0-apache

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends \
    -y libxml2-dev

RUN docker-php-ext-install zip pdo_mysql pdo soap

COPY ./php.ini /usr/local/etc/php/

RUN mkdir public
RUN chmod 777 public

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

# Start Apache in foreground
CMD ["apache2-foreground"]