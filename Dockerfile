# Resmi PHP Docker imajını kullanın
FROM php:8.0.2-apache

# Gerekli bağımlılıkları kurun
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

# Uygulama dosyalarını çalışma dizinine kopyalayın
WORKDIR /var/www/html/
COPY . .

# Composer'ı yükleyin ve bağımlılıkları yükleyin
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html/ && composer install

# Uygulamanın çalışması için gereken komutları çalıştırın
CMD php artisan serve --host=0.0.0.0 --port=8000

# Gerekli portları dışarıya açın
EXPOSE 8000