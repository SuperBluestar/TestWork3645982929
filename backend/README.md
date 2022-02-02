<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Requirement
------
| PHP ^7.3~^8.0 | MySQL |

## How to run project as local development
1. Should install vendors for laravel and sanctum
```terminal
composer install
```
2. Should create .env file by cloning .env.example
```terminal
cp .env.example .env
```
3. Should generate laravel key
```terminal
php artisan key:generate
```
4. Should confirm database
```.env
// .env file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=testwork3645982929
DB_USERNAME=root
DB_PASSWORD=
```
then should create database named testwork3645982929 in mysql using phpadmin or mysqlyog software
5. Should migrate the database
```
php artisan migrate
```
## Auth Management
Authorization is based on Sanctum library.

## Role Management
Role management is based on bitwise operator.

## CRUD Function
CRUD functions are implemented in BlogController
- GET: /blogs (READ)
- GET: /blogs/{id} (READ)
- POST: /blogs (CREATE)
- PUT: /blogs/{id} (UPDATE)
- DELET: /blogs/{id} (DELETE)
