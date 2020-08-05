# url shortener
**WARNING**
If you reanme the folder,must run `composer install `

In case of any issue ,run below command

```sh
composer install
composer update
php artisan config:clear
php artisan key:generate
php artisan migrate:fresh # this will erease your db
php artisan migrate:install
php artisan view:clear

```

And make sure `.env` is correct 

## mysql docker 

```sh
sudo docker pull mysql
sudo docker run -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -d --name=d_sql mysql:latest 
# -rm means when container off will rm the container
sudo docker container start d_sql
sudo docker exec -it d_sql bash
```
set `.env` like this
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_db
DB_USERNAME=root
DB_PASSWORD=root
```
handly create db then use `php artisan migrate` to creat table
```
mysql> CREATE DATABASE `url_db`;
```

## disable kernel Middleware
```
// \Illuminate\Session\Middleware\StartSession::class,
// \Illuminate\Session\Middleware\AuthenticateSession::class,
// \Illuminate\View\Middleware\ShareErrorsFromSession::class,
// \App\Http\Middleware\VerifyCsrfToken::class,
```