FROM php:7.3.11-apache

## Install ssmtp and mailutils on the image
RUN apt-get update && apt-get install -q -y msmtp && rm -rf /var/lib/apt/lists/*

## Enables all the required php and apache modules
RUN docker-php-ext-install pdo pdo_mysql mysqli gettext
RUN a2enmod rewrite headers ssl

## Copy the ssmtp config to the image
COPY ./msmtprc /etc/msmtprc

## Change permission and owner of msmtprc
RUN chmod 0600 /etc/msmtprc
RUN chown www-data:www-data /etc/msmtprc

# Set up php sendmail config
RUN echo "sendmail_path=msmtp -C /etc/msmtprc -t" >> $PHP_INI_DIR/php.ini