<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup your environment

* Install the project dependencies using `composer install` command


* Run `php artisan migrate` for table population


* Field `ADMIN_PASSPHRASE` inside `.env` file, is required to set up your admin passphrase


* For running unit tests in your env file switch the `DB_DATABASE` field to your dedicated testing database
  before running the tests
  
## Laravel sail

* In case you want to use docker you can simply use `vendor/bin/sail up`


* Run `vendor/bin/sail artisan migrate` to run migrations
