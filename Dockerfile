FROM php:8.1-apache

# Cài đặt extension IMAP, PDO MySQL và các tiện ích cần thiết
RUN apt-get update && apt-get install -y \
    libc-client-dev \
    libkrb5-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap pdo_mysql mbstring exif pcntl bcmath gd zip

RUN a2enmod rewrite

# Trỏ DocumentRoot vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html

# Phân quyền ghi cho thư mục lưu trữ của Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
