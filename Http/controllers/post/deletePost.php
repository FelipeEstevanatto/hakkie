<?php

namespace Http\controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

//Follow
if (isset($_POST['deletePost']) && is_numeric($_POST['deletePost'])) {

    $return = $db->query('SELECT * FROM posts WHERE fk_owner = :session_user AND id = :id;', [
        'session_user' => $_SESSION['user']['id'],
        'id' => $_POST['deletePost']
    ])->find();

    if ($return == null) {
        echo"Something went wrong";
        exit();
    }

    $return = $db->query('DELETE FROM files WHERE fk_post = :id AND fk_owner = :session_user RETURNING file_name;', [
        'id' => $_POST['deletePost'],
        'session_user' => $_SESSION['user']['id']
    ])->find();

    if ($return != null) {
        foreach ($return as $filenames) {
            if (file_exists('../../../public/posts/'.$filenames['file_name'])) {  
                if(!unlink('../../../public/posts/'.$filenames['file_name'])){
                    echo "Something went wrong deleting the media";
                }
            }
        }
    }

    $db->query('DELETE FROM likes WHERE fk_post = :id;', [
        'id' => $_POST['deletePost']
    ]);

    $db->query('DELETE FROM comments WHERE fk_post = :id;', [
        'id' => $_POST['deletePost']
    ]);

    $db->query('DELETE FROM notifications WHERE fk_post = :id;', [
        'id' => $_POST['deletePost']
    ]);
}