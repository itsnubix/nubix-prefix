# Nubix Preset for Laravel Application

## Presets
* Laravel Breeze
* Laravel Sail
* Tailwindcss with JIT mode
* Tailwindui
* Github actions
* Mysql
* Vue 3
* Code Linters
    * Eslint
    * Prettier
    * Php-cs-fixer
* PHP packages
    * [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
    * [Laravel Dump Server](https://github.com/beyondcode/laravel-dump-server)
    * [Laravel Nuke](https://github.com/itsnubix/laravel-nuke)
    * [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
    
## Installation
This preset is intended to be installed into a fresh Laravel application. 
Follow [Laravel's installation instructions](https://laravel.com/docs/8.x/installation) to ensure you have a working environment before continuing.

### Requirements
* PHP 8.0 and up
* Laravel 8 and up

### Installation (default with Vue3)
```shell
composer require --dev itsnubix/nubix-preset
php artisan ui nubix

npm install && npm run dev
```
