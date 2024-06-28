# Use the official PHP image from the Docker Hub
FROM php:7.4-apache

# Copy the content of your project to the /var/www/html directory
COPY . /var/www/html/

# Install any additional PHP extensions if needed
# Uncomment and modify the line below as per your project requirements
# RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
