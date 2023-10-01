<?php

namespace Http\controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

//Like
if (isset($_POST['like']) && !is_numeric($_POST['like'])) {

    $return = $db->query('INSERT INTO likes(fk_post, fk_like_owner) VALUES(:fk_post, :fk_like_owner)', [
        'fk_post' => $_POST['like'],
        'fk_like_owner' => $_SESSION['user']['id']
    ]);

    if ($return) {
        echo"1";
    }

//Unlike
} else if (isset($_POST['unlike']) && !is_numeric($_POST['unlike'])) {

    $return = $db->query('DELETE FROM likes WHERE fk_like_owner = :fk_like_owner AND fk_post = :fk_post', [
        'fk_post' => $_POST['unlike'],
        'fk_like_owner' => $_SESSION['user']['id']
    ]);

    if ($return ) {
        echo"0";
    }

}