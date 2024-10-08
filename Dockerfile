# Base image olarak PHP-FPM kullanıyoruz
FROM php:8.1-fpm

# Çalışma dizinini ayarlıyoruz
WORKDIR /var/www

# Sistemi güncelliyoruz ve gerekli bağımlılıkları yüklüyoruz
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Composer kurulumu
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel projesinin bağımlılıklarını kuruyoruz
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Laravel projesini kopyalıyoruz
COPY . .

# Dosya izinlerini ayarlıyoruz
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Uygulama portunu dinlemeye alıyoruz
EXPOSE 9000

# PHP-FPM'yi başlatıyoruz
CMD ["php-fpm"]
