FROM php:8.0-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions mongodb @composer pdo_mysql mbstring zip exif pcntl gd

# Add user for our application
RUN groupadd --gid 1000 pizzaprobably
RUN useradd --create-home --uid 1000 --shell /bin/bash --gid pizzaprobably pizzaprobably

# Copy existing application directory permissions
COPY --chown=pizzaprobably:pizzaprobably ./lumen .

# Change current user to pizzaprobably
USER pizzaprobably

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]