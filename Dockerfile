# Dùng bản PHP 8.2 có sẵn Apache (Web server)
FROM php:8.2-apache

# Cài đặt extension mysqli để kết nối Database MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy toàn bộ code vào thư mục gốc của Apache
COPY . /var/www/html/

# Phân quyền cho Apache (để tránh lỗi không đọc được file)
RUN chown -R www-data:www-data /var/www/html