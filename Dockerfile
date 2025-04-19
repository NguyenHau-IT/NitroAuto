# Sử dụng PHP 8.3 với Apache (bookworm ổn định hơn)
FROM php:8.3-apache-bookworm

# Cài driver ODBC + Microsoft SQL Server Driver
RUN apt-get update && apt-get install -y \
    gnupg2 unixodbc-dev curl apt-transport-https libcurl4-openssl-dev libssl-dev gnupg \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
    && pecl install pdo_sqlsrv sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Sao chép mã nguồn vào container
COPY . /var/www/html

# Trỏ Apache vào thư mục public (nếu có)
WORKDIR /var/www/html
RUN sed -i 's!/var/www/html!/var/www/html/public!' /etc/apache2/sites-available/000-default.conf || true

# Cài gói PHP từ composer
RUN composer install || true

# Cấp quyền thư mục
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
