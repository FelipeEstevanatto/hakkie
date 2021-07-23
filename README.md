# Hakkie
Hakkie is a social networking service on which users post and interact with messages, inspired on twitter of course.

Using PostGreSQL 13.3 on localhost, if you use XAMPP + pgAdmin4, to connect to PG using PDO you will ned to go into your ```xampp/php/php.ini``` file, and uncomment the lines ```extension=pdo_pgsql```, ```extension=pgsql``` and ```extension=opensll``` (not sure to be honest of this one but why not) and restart XAMPP, it should connect fine now.