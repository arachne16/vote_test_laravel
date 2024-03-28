## Setup requirement
- php 8.1
- mysql (I believe will work with any, otherwise use latest)

## Setup
- cp .env.example .env
- put your db creds to .env (e.g. DB_DATABASE=test DB_USERNAME=root DB_PASSWORD=Password1@)
- composer install
- npm i
- php artisan migrate
- php artisan serve && npm run dev

## Note
During email verification, in order not to configure smtp, go to '/storage/logs/laravel.log' and find there verification link. (Your .env should have MAIL_MAILER=log) 

## Used Packages
- [laravel breeze - auth setup and laravel+vue base template+email verification](https://github.com/laravel/breeze)
- [https://github.com/Torann/laravel-geoip - geolocation](https://github.com/Torann/laravel-geoip)

