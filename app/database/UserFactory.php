<?php

use Core\App;
use Core\Database;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../bootstrap.php';

$users = [
    ['username' => 'Felipe','email' => 'felipe@gmail.com','password' => 'felipe'],
    ['username' => 'Nicolim','email' => 'nicolim@gmail.com','password' => 'nicolim'],
    ['username' => 'Jorge','email' => 'jorge@gmail.com','password' => 'jorge']
];

$db = App::resolve(Database::class);
try {
    foreach ($users as $user) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    
        $db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)', $user);
    }
    echo "Users created successfully!";
} catch (PDOException $e) {
    echo 'Error: '.$e->getCode().' Message: '.$e->getMessage();
}
