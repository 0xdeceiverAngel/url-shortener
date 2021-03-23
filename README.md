# url shortener
## demo
[![](http://img.youtube.com/vi/AR_jjRIQ4NQ/0.jpg)](http://www.youtube.com/watch?v=AR_jjRIQ4NQ "")
## feature
- use recaptcha to avoid abuse
- shorten url redirect
- private image share,lock with password
- use redis be cache,queue db action
- dockerize
## base on 
- laravel 
- mysql
- redis
- jquery
- bootstrap
- html 
- css
- npm
- docker
- docker-compose
## start app
run `docker-compose up -d`

wait a moment until laravel start

visit `127.0.0.1:8000`

## volume file
add below to `docker-compose.yml`
```
web:
      build: .
      ports:
        - 8000:8000
      tty: true
      network_mode: "host"
      depends_on:
        - "redis"
      volumes:             # add this
        - .:/project       # add this
```
it will mount whole folder to `/project` in docker.keep environment remain,can also debug inside docker

### route
**recommend read on editor** or **run `php artisan route:list`**
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
### disable kernel Middleware
see kernel.php
### other 

**WARNING**

If you reanme the folder or clone from github,must run `composer install `

If have other unknown issue ,run below command

```sh
composer install
php artisan config:clear
php artisan cache:clear
php artisan key:generate
php artisan migrate:fresh # this will erease your db
php artisan view:clear

```

And make sure `.env` is correct 

#### mysql and redis docker 

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
php artisan db:create
```

#### 起源

因為想要練練，所以選擇了縮網址服務，原本第一版2020/7 只有很陽春的像 https://is.gd/ 這樣縮

後來因為想要投後端實習，所以第二版加上類似 https://risu.io/ 的功能，可以存圖片，並且設定密碼(可設可不設)

考慮到效能的問題，所以有用redis做快取，不用再去db找要指向哪個url，加快反應速度

避免race condition，所以db的寫入都丟到queue排隊，有即時改動需求的話，可以插隊

有記錄導向時間，建立時間，導向次數

為了防爬蟲，所以縮網址的api有用recaptcha做驗證

維持環境一致，自己寫dockerfile，之後debug 只要把檔案掛載進去就好了

但是缺點也是有的，db的結構設計不好、redis的key沒有取好名字，code有點亂、UI有點醜，db 沒用master slave 等其他架構

前前後後找了7、8本書來看
#### 遇到的坑

不得不說，用laravel坑真的有點多，從2020/7開始碰到現在2021/3，數不清的神奇坑洞

不過其中有個坑是firefox的鍋，html input file 會無法選擇

內建middleware會莫名其妙噴錯 而且middleware還不能亂關，關掉會噴錯，不關也噴錯

原本的code沒變，加上新code，就抓不到舊東西

以上是自己的看法，也可能是我太弱雞，需要再加強

2021/3/23更新

vm死掉重新灌一次，build images時，被LF CRFL陰了一把


