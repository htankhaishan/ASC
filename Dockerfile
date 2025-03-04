FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install ExifTool (For CVE-2021-22204 testing)
RUN apt update && apt install -y libimage-exiftool-perl

# Enable necessary Apache modules
RUN a2enmod rewrite

# Fix Apache permissions issue
RUN echo "<Directory /var/www/html/>" >> /etc/apache2/apache2.conf && \
    echo "Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf && \
    echo "AllowOverride All" >> /etc/apache2/apache2.conf && \
    echo "Require all granted" >> /etc/apache2/apache2.conf && \
    echo "</Directory>" >> /etc/apache2/apache2.conf

# Restart Apache
RUN service apache2 restart

# Set working directory
WORKDIR /var/www/html

# Copy website files into container
COPY . /var/www/html

# Set correct file permissions
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
