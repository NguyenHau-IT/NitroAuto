FROM php:8.3-apache-bookworm

# Cài Microsoft SQL Server Driver (fix NO_PUBKEY)
RUN apt-get update && apt-get install -y \
    gnupg2 curl apt-transport-https unixodbc-dev \
    libcurl4-openssl-dev libssl-dev lsb-release ca-certificates \
 && curl -sSL https://packages.microsoft.com/keys/microsoft.asc -o /usr/share/keyrings/microsoft.asc \
 && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft.asc] https://packages.microsoft.com/debian/12/prod bookworm main" \
 > /etc/apt/sources.list.d/mssql-release.list \
 && apt-get update \
 && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
 && pecl install pdo_sqlsrv sqlsrv \
 && docker-php-ext-enable pdo_sqlsrv sqlsrv

# Cài composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Bật rewrite cho Apache
RUN a2enmod rewrite

# Copy mã nguồn
COPY . /var/www/html

WORKDIR /var/www/html
RUN sed -i 's!/var/www/html!/var/www/html/public!' /etc/apache2/sites-available/000-default.conf || true

RUN composer install || true
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
