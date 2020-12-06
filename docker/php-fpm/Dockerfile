FROM php:8-fpm

WORKDIR /var/www/web

RUN mkdir mkdir -p /usr/share/man/man1/ /usr/share/man/man7/ && apt-get update && apt-get install -y --no-install-recommends -f openssl libssl-dev libzip-dev ca-certificates libicu-dev libpq-dev curl zlib1g-dev libmemcached-dev wget zip unzip git phantomjs libmagickwand-dev libldb-dev libldap2-dev sshpass postgresql-client libc-client-dev libkrb5-dev iproute2 && rm -rf /var/lib/apt/lists/* && apt-get clean

RUN PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install zip bcmath sockets intl ldap exif imap pdo

RUN mkdir -p /usr/src/php/ext/memcached && curl -fsSL https://pecl.php.net/get/memcached | tar xvz -C "/usr/src/php/ext/memcached" --strip 1 && docker-php-ext-install memcached
RUN mkdir -p /usr/src/php/ext/xdebug && curl -fsSL https://pecl.php.net/get/xdebug | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 && docker-php-ext-install xdebug

RUN ln -s /usr/bin/curl /usr/local/bin/curl

RUN curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN echo "xdebug.client_host="`/sbin/ip route|awk '/default/ { print $3 }'` >> /usr/local/etc/php/conf.d/xdebug.ini