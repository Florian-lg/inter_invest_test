# Php 8.0 fpm
# XDebug

FROM php:8.1-fpm

# Libraries
RUN apt-get update && apt-get install -y git vim zip unzip wget libjpeg-dev libpng-dev libicu-dev libpq-dev libzip-dev ruby-full ruby-ffi default-mysql-client esmtp

# Php extensions
RUN docker-php-ext-configure gd --with-jpeg \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl gd pdo_mysql pdo_pgsql mysqli zip bcmath

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

# Xdebug
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=\${DOCKER_ADDR}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini

# Node js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get update &&  apt-get install -y nodejs build-essential \
    && rm -rf /var/lib/apt/lists/*

# Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - >/dev/null \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update && apt-get install -y yarn \
    && rm -rf /var/lib/apt/lists/*

# Gulp
RUN npm install --global gulp-cli

# Compass
RUN gem install compass

# Alias l
RUN echo 'alias l="ls -lsa"' >> ~/.bashrc

# Alias Symfony 
RUN echo 'alias ci="composer install"' >> ~/.bashrc
RUN echo 'alias cc="bin/console cache:clear"' >> ~/.bashrc
RUN echo 'alias dsu="bin/console doctrine:schema:update --force"' >> ~/.bashrc
RUN echo 'alias me="bin/console make:entity"' >> ~/.bashrc

# Alias Yarn
RUN echo 'alias yi="yarn install"' >> ~/.bashrc
RUN echo 'alias ydev="yarn encore dev"' >> ~/.bashrc
RUN echo 'alias ywatch="yarn encore dev --watch"' >> ~/.bashrc

# Wkhtmltopdf
RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.stretch_amd64.deb \
    && apt-get update && apt-get install -y fontconfig libfreetype6 libxrender1 xfonts-75dpi xfonts-base \
    && apt --fix-broken install \
    && dpkg -i wkhtmltox_0.12.6-1.stretch_amd64.deb

# Esmtp (sendmail)
RUN ln -s /usr/bin/esmtp /usr/bin/sendmail
COPY conf/esmtprc /etc/esmtprc

# php-fpm conf
RUN echo "sendmail_path = /usr/bin/sendmail -t -i\n" \
         "memory_limit = 512M\n" \
         "max_execution_time = 120\n" \
         >> /usr/local/etc/php/conf.d/docker-extraconf.ini

# MSSQL
RUN apt-get install -y unixodbc-dev \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

