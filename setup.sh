#!/bin/bash
apt-get update 
apt-get install software-properties-common -y
add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get install --assume-yes apt-utils -y 
apt-get install netcat -y
# apt install -y php-mysql php-fpm php-mbstring 
apt-get install -y php7.4-fpm php7.4-mysql php7.4-mcrypt php7.4-gd php7.4-cli php7.4-curl php7.4-imap php7.4-mbstring php7.4-tokenizer php7.4-xml php7.4-json php7.4-common zip unzip php7.4-zip 
# apt-get install php7.4 -y
#  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
apt-get install curl -y 

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# composer global require laravel/installer
# composer update
composer install

