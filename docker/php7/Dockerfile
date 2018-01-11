FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y  git \
            wget \
            zip \
            openjdk-7-jre \
            libpq-dev \
            libicu-dev \
            npm \
            libfreetype6-dev \
            libmcrypt-dev \
            libmemcached-dev \
            libjpeg62-turbo-dev \
            libpng12-dev

### composer
RUN cd / && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install \
    intl \
    exif \
    zip \
    opcache \
    bcmath \
    mbstring \
    -j$(nproc) iconv mcrypt \
    pdo \
    pdo_mysql

# Install Imagick.
RUN apt-get update && apt-get install -y \
    libmagickwand-dev
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Download and install wkhtmltopdf
RUN apt-get update && apt-get install -y build-essential gdebi libssl-dev libxrender-dev xvfb
RUN wget https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.2.1/wkhtmltox-0.12.2.1_linux-jessie-amd64.deb
RUN gdebi --n wkhtmltox-0.12.2.1_linux-jessie-amd64.deb

### copy php config files
COPY ./config/ /usr/local/etc/

#Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_7.x | bash -
RUN apt-get install -y nodejs

##Install Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get -y install yarn

WORKDIR /var/www