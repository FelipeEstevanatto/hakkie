<?php

namespace Http\controllers;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$users = $db->query('SELECT DISTINCT users.id FROM users INNER JOIN posts ON fk_owner = users.id')->get();
include(__DIR__ . "../post/showPosts.php");

view("home.view.php", [
    'heading' => 'Home',
    'users' => $users,
]);