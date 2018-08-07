# Установка, настройка, выполнение

1. Создать директорию `users`
2. Прейти в директорию `cd users`
3. `git clone https://github.com/sergey144010/users`
4. `composer install`
5. Заполнить настройки подключения к базе в файле
```php
db/config.php
```
6. Схема базы данных в файле db/create_tables.ini.
Создать таблицы базы данных или вручную или запустить скрипт
```php
php db/createTables.php
```
7. Запустить встроенный веб сервер
```php
php -S localhost:8000 -t web/
```

8. В браузере перейти на localhost:8000

### Dev enviroment

Mysql 5.6.22. Php 7.1.5
