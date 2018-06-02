FROM php:7.0-apache
RUN apt-get update && apt-get install -y \
  zip \
  unzip \
  git-core \
  vim \
  && docker-php-source extract\
  && docker-php-ext-install pdo_mysql mysqli \
  && apt-get clean
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite \
  && service apache2 restart
