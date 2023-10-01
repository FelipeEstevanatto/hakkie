<?php

namespace Http\controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if ( !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    //This user does not exist in DB!
    view("user-blocked.view.php", [
        'heading' => 'User blocked',
    ]);
    exit();      
}

$post = $_GET['id'];

$return = $db->query("SELECT user_blocked FROM blocks WHERE fk_user = :id", [
    'id' => $post
])->find();

if ($return == null) {
    view("user-blocked.view.php", [
        'heading' => 'User blocked',
    ]);
    exit();
}

$return = $db->query("SELECT id FROM users INNER JOIN posts ON fk_owner = id WHERE id = :id", [
    'id' => $post
])->find();

$id = $return['id'];

view("post.view.php", [
    'heading' => 'Post',
]);