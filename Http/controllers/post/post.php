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

//dd($return);
if ($return != null) {

    $return = $db->query("SELECT user_blocked FROM blocks WHERE user_blocked = :id", [
        'id' => $post
    ])->find();
    // If session user blocked this user or this user blocked session user
    $details = $return['user_blocked'] == $_SESSION['user']['id'] ? 'own_block' : 'blocked';

    view("user-blocked.view.php", [
        'heading' => 'User blocked',
        'details' => $details,
    ]);
    exit();
}

$return = $db->query("SELECT users.id FROM users INNER JOIN posts ON posts.fk_owner = users.id WHERE posts.id = :id", [
    'id' => $post
])->find();

$id = $return['id'];
include(__DIR__ . "/showPosts.php");
view("post.view.php", [
    'heading' => 'Post',
    'id' => $id,
    'post' => $post,
    
]);