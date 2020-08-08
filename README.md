# url shortener
## **WARNING**
If you reanme the folder or clone from github,must run `composer install `

If have other unknown issue ,run below command

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
sudo docker exec -it d_sql bash # get in to sql shell 
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
## start app
make sure your sqldb docker is on and run `php artisan serve`

visit `127.0.0.1:8000`

### other
#### disable kernel Middleware
```
// \Illuminate\Session\Middleware\StartSession::class,
// \Illuminate\Session\Middleware\AuthenticateSession::class,
// \Illuminate\View\Middleware\ShareErrorsFromSession::class,
// \App\Http\Middleware\VerifyCsrfToken::class,
```