# url shortener
## demo
http://www.youtube.com/watch?v=ViM7Jy5xI7s
## feature
- use recaptcha to avoid abuse
- shorten url redirect
- private image share,lock with password
- use redis be cache,queue db action
## base on 
- docker
- laravel 
- mysql
- redis
- jquery
- bootstrap
- html 
- css
- npm
## **WARNING**
If you reanme the folder or clone from github,must run `composer install `

If have other unknown issue ,run below command

```sh
composer install
composer update
php artisan config:clear
php artisan cache:clear
php artisan key:generate
php artisan migrate:fresh # this will erease your db
php artisan migrate:install
php artisan view:clear

```

And make sure `.env` is correct 

## mysql and redis docker 

```sh
sudo docker pull mysql
sudo docker run -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -d --name=d_sql mysql
# -rm means when container off will rm the container
sudo docker container start d_sql
sudo docker exec -it d_sql bash # get in to sql shell 


sudo docker pull redis
sudo docker run  -p 6379:6379 -d --name=d_redis redis
sudo docker container start d_redis
```
set `.env` like this
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_db
DB_USERNAME=root
DB_PASSWORD=root

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
handly create db then use `php artisan migrate` to creat table
```
mysql> CREATE DATABASE `url_db`;
```
## start app
make sure docker is ready,run `npm run up`

visit `127.0.0.1:8000`

### route
```
+--------+----------+-------------------------------+------+------------------------------------------------------------+------------------+
| Domain | Method   | URI                           | Name | Action                                                     | Middleware       |
+--------+----------+-------------------------------+------+------------------------------------------------------------+------------------+
|        | GET|HEAD | /                             |      | App\Http\Controllers\LoginCon@index                        | web              |
|        | GET|HEAD | ajax-file-upload-progress-bar |      | App\Http\Controllers\ProgressBarUploadFileController@index | web              |
|        | POST     | api                           |      | App\Http\Controllers\url_mapping@creat_url                 | web              |
|        |          |                               |      |                                                            | g-recaptcha      |
|        | GET|HEAD | api/user                      |      | Closure                                                    | api              |
|        |          |                               |      |                                                            | auth:api         |
|        | POST     | change_pw                     |      | App\Http\Controllers\url_manage@change_pw                  | web              |
|        |          |                               |      |                                                            | check_is_login   |
|        |          |                               |      |                                                            | check_url_verify |
|        | GET|HEAD | dashboard                     |      | App\Http\Controllers\LoginCon@dashboard                    | web              |
|        |          |                               |      |                                                            | check_is_login   |
|        | GET|HEAD | db1                           |      | Closure                                                    | web              |
|        | GET|HEAD | db2                           |      | Closure                                                    | web              |
|        | POST     | delete                        |      | App\Http\Controllers\url_manage@delete_url                 | web              |
|        |          |                               |      |                                                            | check_is_login   |
|        |          |                               |      |                                                            | check_url_verify |
|        | POST     | img_api                       |      | App\Http\Controllers\url_mapping@img_creat                 | web              |
|        |          |                               |      |                                                            | g-recaptcha      |
|        | POST     | login                         |      | App\Http\Controllers\LoginCon@login                        | web              |
|        | GET|HEAD | logout                        |      | App\Http\Controllers\LoginCon@logout                       | web              |
|        | GET|HEAD | php                           |      | Closure                                                    | web              |
|        | POST     | register                      |      | App\Http\Controllers\LoginCon@register                     | web              |
|        | POST     | store                         |      | App\Http\Controllers\ProgressBarUploadFileController@store | web              |
|        | GET|HEAD | {hash}                        |      | App\Http\Controllers\url_mapping@redirect                  | web              |
|        |          |                               |      |                                                            | check_url_cache  |
|        | POST     | {hash}/verify                 |      | App\Http\Controllers\url_mapping@img_pw_verify             | web              |
|        |          |                               |      |                                                            | g-recaptcha      |
+--------+----------+-------------------------------+------+------------------------------------------------------------+------------------+

```
#### disable kernel Middleware
> see kernel.php
