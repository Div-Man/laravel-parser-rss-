#### Установка:

Версия PHP 8.1.

**folder** заменить на название папки

1. ```git clone git@github.com:Div-Man/laravel-parser-rss-.git folder```
2. Перейти в папку с проектом.
3. ```composer update```
4. ```cp .env.example .env```
5. ```php artisan key:generate```
6. Настроить подключение к БД в .env
7. ```php artisan migrate```

При необходимости, если будет ошибка **Permission denied**, изменить доступ к папкам и файлам

1. ```sudo chown -R www-data:www-data storage/logs```
2. ```sudo chown -R www-data:www-data storage/framework/sessions```
3. ```sudo chown -R www-data:www-data storage/framework```
4. ```sudo chown -R www-data:www-data storage/framework/cache```
5. ```sudo chown -R $USER:www-data storage```
6. ```sudo chown -R $USER:www-data bootstrap/cache```
7. ```sudo chmod -R 775 storage```
8. ```sudo chmod -R ugo+rw storage```


Добавить ссылку, для отображения изображений

```php artisan storage:link```


Для парсинга RSS запустить команду:

```php artisan app:parsing-news``` (первый раз у меня парсится 3 минуты)

Если во время выполнения этой команды, будет ошибка **Permission denied**, то настроить права:

```sudo chmod o+w ./storage/ -R```

Роут ```Route::get('news/create', [NewsController::class, 'create']);``` делает тоже самое.


Роут для отображения новостей ```http://localhost/news```


Лайки и дизлайки добавляются с помощью **axios**.

Так как тегов в RSS нету, за место них, были взяты категории.

Для парсинга используется пакет [Laravel Feed Reader](https://github.com/vedmant/laravel-feed-reader).

![Alt text](https://github.com/Div-Man/laravel-parser-rss-/blob/master/public/rss1.png)
***
![Alt text](https://github.com/Div-Man/laravel-parser-rss-/blob/master/public/rss3.png)
![Alt text](https://github.com/Div-Man/laravel-parser-rss-/blob/master/public/rss4.png)


