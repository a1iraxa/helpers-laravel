<?php
// Make sure to be in Project Directory

// After updating composer or .env FILES
composer dump-autoload

// Clear Cache
php artisan clear:cache

// After changes in config files
php artisan clear:config

// Updating Routes
php artisan clear:route
