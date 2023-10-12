<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
echo 'Environment: ' . $_ENV['ENVIRONMENT'] . PHP_EOL;
// Create a PDO object to connect to the MySQL server without specifying the database name
$pdo = new PDO($_ENV['DB_ENGINE'] . ':host=' . $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

// Create the database if it doesn't exist
$pdo->exec('DROP DATABASE IF EXISTS ' . $_ENV['DB_NAME']);
$pdo->exec('CREATE DATABASE ' . $_ENV['DB_NAME']);

// Connect to the database and execute the SQL file
$pdo = new PDO($_ENV['DB_ENGINE'] . ':host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$pdo->exec(file_get_contents(__DIR__ . '/database.sql'));

echo 'Database created successfully' . PHP_EOL;
?>