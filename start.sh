#!/bin/sh

# Jalankan migrasi database
php artisan migrate --force

# Nyalakan server Apache
apache2-foreground