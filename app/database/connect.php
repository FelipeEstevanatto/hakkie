<?php

if ( file_exists($_SERVER['DOCUMENT_ROOT'].'/hakkie/app/database/env.php')) {

  require_once("env.php");

} else {

  DEFINE('DATABASE_INFO', [
    'dsn' => 'pgsql:host='.getenv('DATABASE_HOST').';port=5432;dbname='.getenv('DATABASE_NAME'),
    'user' => getenv('POSTGRES_USER'),
    'password' => getenv('DATABASE_PASSWORD')
  ]);

  DEFINE('PHPMAILER_INFO', [
    'smtp_host' => 'smtp.gmail.com',
    'mail_user' => getenv('PHPMAILER_MAIL'),
    'password_user' => getenv('PHPMAILER_PASSWORD'),
    'mail_port' => 465
  ]);
}

  try {
    $conn = new PDO( DATABASE_INFO['dsn'],DATABASE_INFO['user'] ,DATABASE_INFO['password'] );
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
    echo 'Error: '.$e->getCode().' Message: '.$e->getMessage();
  }
