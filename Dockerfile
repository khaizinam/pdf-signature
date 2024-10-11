FROM php:8.2-fpm AS production

###################### Set working directory
WORKDIR /var/www

# Arguments defined in docker-compose.yml
ARG user
ARG uid

###################### Install system dependencies
RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

###################### Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# RUN pecl install oauth && echo "extension=oauth.so" > /usr/local/etc/php/conf.d/docker-php-ext-oauth.ini

###################### Install Node, NVM, NPM and Gulp
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - && apt-get install -y nodejs build-essential

RUN npm install -g npm
RUN npm install -g gulp

# copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./
# RUN npm audit fix --force && npm install --legacy-peer-deps && gulp sass && gulp ts && gulp scripts

###################### Install / Get latest Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

###################### Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

USER $user
