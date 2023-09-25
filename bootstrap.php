<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->safeLoad();

$GLOBALS['base_url'] = 'http://localhost/hakkie/';

try {
    $conn = new PDO($_ENV['DB_ENGINE'] . ':host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch (PDOException $e) {
    echo 'Error: '.$e->getCode().' Message: '.$e->getMessage();
}

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind('Core\Database', function () {
    $config = [
        'database' => [
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => $_ENV['DB_PORT'] ?? 3306,
            'dbname' => $_ENV['DB_NAME'] ?? 'hakkie_db',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4'
        ]
    ];

    return new Database($config['database'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
});

App::setContainer($container);