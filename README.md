# url shortener
**WARNING**
If you reanme the folder,must run `composer install `

In case of any issue ,run below command

```sh
composer install
php artisan config:clear
php artisan key:generate
php artisan migrate:fresh # this will erease your db
```

And make sure `.env` is correct 