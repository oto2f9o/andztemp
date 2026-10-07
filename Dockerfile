FROM php:8.2-apache

# Cài đặt công cụ hỗ trợ tự động cấu hình extension PHP
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Cài đặt extension IMAP, PDO MySQL và các tiện ích cần thiết
RUN install-php-extensions imap pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite cho Laravel
RUN a2enmod rewrite

# Trỏ DocumentRoot vào thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy toàn bộ mã nguồn vào container
COPY . /var/www/html

# Tự động tạo các thư mục lưu trữ nếu thiếu và phân quyền ghi cho Laravel
RUN mkdir -p /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
