<?php

session_start();

require_once("../../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if ( (isset($_POST['followbypost']) && is_numeric($_POST['followbypost'])) || (isset($_POST['unfollowbypost']) && is_numeric($_POST['unfollowbypost'])) ) {
    
    $query = 'SELECT id_user FROM users,posts WHERE posts.fk_owner = users.id_user AND posts.id_post = :id_post';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', $_POST['followbypost'] ?? $_POST['unfollowbypost']);
    
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['followbypost'])) {
        $_POST['follow'] = $return['id_user'];
    } else {
        $_POST['unfollow'] = $return['id_user'];
    }
        
}

//Follow
if (isset($_POST['follow']) && is_numeric($_POST['follow'])) {

    $query = 'INSERT INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id_user) ON CONFLICT DO NOTHING;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_POST['follow'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"1";
    }

//Unfollow
} elseif (isset($_POST['unfollow']) && is_numeric($_POST['unfollow'])) {

    $query = 'DELETE FROM follows WHERE user_followed = :user_unfollowed AND fk_user = :id_user;';

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_unfollowed', $_POST['unfollow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0";
    }

}

$conn = null;
