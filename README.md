# Laravel e-Commerce Application with pre-build admin 

Laravel is a web application framework with expressive, elegant syntax. So this is a admin panel with basic functionality used in this like Admin Roles, Users, Category, SubCategory, Product and Pages.
This all things is pre-built with permissions and admin roles. You just have to follow the steps and run the admin and use it as you wish.

**We've also integrate an `Vue.JS` for front-end coding in admin panel**

## Prerequisites

##### What things you need to install this project and how to setup the project on local
1. **PHP [![Version](https://shields.io/badge/version-v7.3-green)](https://www.php.net/releases/7_3_0.php)** 
2. **Laravel [![Version](https://shields.io/badge/version-v8.0-red)](https://laravel.com/docs/8.x)**
3. **Composer [![Version](https://shields.io/badge/version-v2.0-blue)](https://getcomposer.org/)**
3. **MySql [![Version](https://shields.io/badge/version-v8.0-orange)](https://www.phpmyadmin.net/)**

## Steps to Run the project
- Clone the project from github
- Copy Env File and fill appropriate details
- Run Following commands for basic setup
- `composer install`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan key:generate`
- `php artisan storage:link`
- `php artisan initialize:admin`
    - This will create basic permissions for application admin
- `php artisan serve`
- Now Hit the url http://127.0.0.1:8000/webadmin/login for login to admin with username password (123456). Grab the username from database
- **All Set. Done :+1: !**


## Notes
- This is project is under development currently so you might not want to use this app in production directly.
- This is just a skeleton/example how you can implement admin panel with [spatie larvel permissions.](https://spatie.be/docs/laravel-permission/v5/introduction)
- If you discover a security vulnerability within Laravel, please send an e-mail to Tarang Panchal via [tarang.webinfosolutions@gmail.com](mailto:tarang.webinfosolutions@gmail.com). All security vulnerabilities will be promptly addressed.

### Contribution

I love to welcome your contributions if you know Laravel / Vue.js.

Special thanks to [@monish](https://github.com/monish-khatri) for creating readme file


### Steps to Run the project

- Clone the project from github
- Copy Env File and fill appropriate details
- Run command `php artisan migrate`
- Run command `php artisan db:seed`
- Run command `php artisan initialize:admin`
- Run command `php artisan storage:link`
- this will create appropriate permissions for application admin
- Run command `php artisan serve`
- All Set. Done +1 !

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Tarang Panchal via [tarang.webinfosolutions@gmail.com](mailto:tarang.webinfosolutions@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The MIT License (MIT). Please see [License]() File for more information.
