<?php

namespace Http\controllers;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$return = $db->query('SELECT DISTINCT users.id FROM users INNER JOIN posts ON fk_owner = users.id')->find();

view("home.view.php", [
    'heading' => 'Home',
    'return' => $return,
]);