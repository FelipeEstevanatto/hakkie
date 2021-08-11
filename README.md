# Hakkie
Hakkie is a social networking service on which users post and interact with eachother with comments, likes, messages, blocks and silencing, inspired on twitter of course.

# How to install on localhost

If you want to make it easier to 'plug and play' you can use the same combo [XAMPP >= 3.3](https://www.apachefriends.org/pt_br/download.html) with PHP 8 and [PostGreSQL 13](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads), then you will need to insert the application [SQL tables](https://github.com/FelipeEstevanatto/hakkie/blob/main/app/database/sql.sql) in a database called ```hakkie_db``` using pgAdmin 4 or SQL Shell(psql), then to connect to PG database using PDO with Postgre you will need to go into your ```xampp/php/php.ini``` file, and uncomment the 3 lines bellow and restart XAMPP  
```extension=pdo_pgsql```  
```extension=pgsql```  
```extension=opensll```  

To use all features of the project you will need to install the packages it uses using [Composer](https://getcomposer.org/), opening it in the root folder, and requiring the packages:  
```composer require google/apiclient```
```composer require phpmailer/phpmailer```  

Then you will need to rename the ```env_example.php``` file to ```env.php``` and fill the blank spaces with the correct database info and PHPMailer account (to use a google one you will need to go Security tab and allow Acess to a less safe app)

Then you should be ready to go and create your account to user the project.
