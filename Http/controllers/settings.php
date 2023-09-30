<?php

namespace Http\controllers;

use Core\App;
use Core\Database;

$_SESSION['email'] = 'felipe.estevanatto@gmail.com';

$db = App::resolve(Database::class);

$user = $db->query("SELECT * FROM users WHERE email = :email", [
    'email' => $_SESSION['email']
])->find();

$name = $user['username'];
$email = $user['email'];
$info = $user['user_info'];
$theme = $user['darkmode'];

$blocks = $db->query("SELECT users.id, users.username, users.picture, users.auth_type, blocks.block_date, blocks.id FROM users INNER JOIN blocks ON users.id = blocks.user_blocked WHERE blocks.fk_user = :id;", [
    'id' => $_SESSION['user']['id']
])->find();

if (empty($blocks)) {
    $hasBlocks = false;
} else {
    $hasBlocks = true;
}

view("settings.view.php", [
    'heading' => 'Settings',
    'name' => $name,
    'email' => $email,
    'info' => $info,
    'theme' => $theme,
    'hasBlocks' => $hasBlocks,
]);