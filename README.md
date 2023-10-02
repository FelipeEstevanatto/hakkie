# Hakkie
Hakkie is a social networking service on which users post and interact with eachother with comments, likes, messages, blocks and silencing, inspired on twitter of course, and made in plain PHP as a way to study it more.

# How to install on localhost

If you want to make it easier to 'plug and play' you can use the same combo [XAMPP with PHP 8.2 and Mysql](https://www.apachefriends.org/pt_br/download.html) , then you can manage the application database with [DBeaver Community](https://dbeaver.io/download/)

To use and setup the project you will need to clone it inside the htdocs folder of xampp, and install the packages it's using with [Composer](https://getcomposer.org/), opening it in the root folder, and running:  
```composer install```
Then you will need to copy the ```env_example.php``` file to ```env.php``` and fill the blank spaces with the correct database info and PHPMailer account
And the last you should run the script to set up the database with the command:
```composer run setup-database```

Then you should be ready to go and create your account to use the project.

But if you want to integrate the google login you will need to create a project on [Google Cloud Platform](https://console.cloud.google.com/) and enable the Google+ API, then create a OAuth 2.0 Client ID and download the credentials.json file, and put it in the root folder of the project, then you will need to run the command:
```composer run setup-google-login```