<?php

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();


// if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/hakkie/app/database/env.php')) {

//     require_once("env.php");

// } else {

//     DEFINE('DATABASE_INFO', [
//         'dsn' => $_ENV['DB_ENGINE'].':host='.$_ENV['DB_HOST'].';port=5432;dbname='.$_ENV['DB_NAME'],
//         'user' => $_ENV['DB_USER'],
//         'password' => $_ENV['DB_PASSWORD']
//     ]);

//     DEFINE('PHPMAILER_INFO', [
//         'smtp_host' => $_ENV['PHPMAILER_HOST'],
//         'mail_user' => $_ENV['PHPMAILER_MAIL'],
//         'password_user' => $_ENV['PHPMAILER_PASSWORD'],
//         'mail_port' => $_ENV['PHPMAILER_PORT']
//     ]);
// }

try {
  $conn = new PDO($_ENV['DB_ENGINE'] . ':host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
  $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  echo 'Error: '.$e->getCode().' Message: '.$e->getMessage();
}
