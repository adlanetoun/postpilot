web: php artisan config:clear && php -r "\$db='/app/database/database.sqlite'; \$q='/app/database/database_queue.sqlite'; @mkdir('/app/database',0777,true); foreach([\$db,\$q] as \$f){if(!file_exists(\$f)){touch(\$f);chmod(\$f,0666);}}" && php artisan migrate --force && php artisan view:clear && php artisan serve --host 0.0.0.0 --port $PORT
# Clean Railway SQLite deployment
