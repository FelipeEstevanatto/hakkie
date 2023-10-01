<?php

namespace Http\controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

//Follow
if (isset($_POST['follow']) || is_numeric($_POST['Unfollow'])) {
    // Check if user is already following

    $return = $db->query('SELECT * FROM follows WHERE user_followed = :user_followed AND fk_user = :id;', [
        'user_followed' => $_POST['follow'],
        'id' => $_SESSION['user']['id']
    ])->find();

    if ($return == null) {
        $query = 'INSERT IGNORE INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id);';
    } else {
        $query = 'DELETE FROM follows WHERE user_followed = :user_followed AND fk_user = :id;';
    }

    $return = $db->query($query, [
        'user_followed' => $_POST['follow'],
        'id' => $_SESSION['user']['id']
    ]);

    if ($return) {
        echo"Success";
    }
}