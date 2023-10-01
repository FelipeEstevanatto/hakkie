<?php

namespace Http\controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

//Follow
if (isset($_POST['follow']) && is_numeric($_POST['follow'])) {

    $query = 
        'DO
        $do$
        BEGIN
            IF (NOT EXISTS(SELECT * FROM follows WHERE fk_user = :id AND user_followed = :user_followed)) THEN
                INSERT INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id);
            END IF;
        END
        $do$;
        UPDATE users SET user_followers = user_followers+1 WHERE id = :user_followed;
        UPDATE users SET user_following = user_following+1 WHERE id = :id;
        ';
    //Force PDO to either always emulate prepared statements
    //$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $db->query($query);

    if ($stmt) {
        echo "1";
    }

//Unfollow
} elseif (isset($_POST['unfollow']) && is_numeric($_POST['unfollow'])) {

    $stmt = $db->query('DELETE FROM follows WHERE user_followed = :user_unfollowed AND fk_user = :id;
    UPDATE users SET user_followers = user_followers-1 WHERE id = :user_unfollowed;
    UPDATE users SET user_following = user_following-1 WHERE id = :id;',[
        'user_unfollowed' => $_POST['unfollow'],
        'id' => $_SESSION['user']['id'],
        'user_unfollowed' => $_POST['unfollow'],
        'id' => $_SESSION['user']['id']
    ]);

    if ($stmt) {
        echo "0";
    }

}