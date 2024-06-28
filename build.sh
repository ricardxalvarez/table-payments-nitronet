#!/bin/bash

# Ensure script fails on any error
set -e

# Create the build directory
mkdir -p ./build

# Copy project files to the build directory
cp -r ./* ./build

# Change to the build directory
cd ./build

# Setup Apache configuration if needed
# Example of creating an .htaccess file for URL rewriting
echo "RewriteEngine On
RewriteRule ^ index.php [L]" > ./.htaccess

# Optional: Install dependencies if your project has a composer.json file
if [ -f composer.json ]; then
    composer install --no-dev
fi
