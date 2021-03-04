#!/bin/bash
# ./test.sh
# php artisan config:clear
# php artisan cache:clear
# php artisan key:generate
# php artisan view:clear
# php artisan db:create url_db
# php artisan migrate
# php artisan queue:work&
# # php artisan serve
# php artisan serve --host 0.0.0.0 --port 8000


for i in {1..60};
do
    res=$(nc -zv 127.0.0.1 3306 2>&1|grep succeeded -oE)
    echo $res
    if [ "$res" = "succeeded" ]
        then
            # php artisan config:clear
            # php artisan cache:clear
            # php artisan key:generate
            # php artisan view:clear
            php artisan db:create url_db
            php artisan migrate
            php artisan queue:work&
            php artisan serve --host 0.0.0.0 --port 8000
        break
    fi
    sleep 1
done
# exit 1
