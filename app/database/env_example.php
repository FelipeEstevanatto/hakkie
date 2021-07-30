<?php

if (!defined('DATABASE_INFO') || !defined('DATABASE_INFO')) {
    DEFINE('DATABASE_INFO', [
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=hakkie_db',
        'user' => 'postgres',
        'password' => ''
    ]);

    DEFINE('PHPMAILER_INFO', [
        'smtp_host' => 'smtp.gmail.com',
        'mail_user' => '',
        'password_user' => '',
        'mail_port' => 465 //587
    ]);
}
