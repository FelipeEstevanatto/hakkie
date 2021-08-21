<?php

session_start();

require_once("../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if ( (isset($_POST['blockbypost']) && is_numeric($_POST['blockbypost'])) || (isset($_POST['unblockbypost']) && is_numeric($_POST['unblockbypost'])) ) {
    
    $query = 'SELECT id_user FROM users,posts WHERE posts.fk_owner = users.id_user AND posts.id_post = :id_post';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', $_POST['blockbypost'] ?? $_POST['unblockbypost']);
    
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST['followbypost'])) {
        $_POST['follow'] = $return['id_user'];
    } else {
        $_POST['unfollow'] = $return['id_user'];
    }
        
}

if (isset($_POST['unblock']) && is_numeric($_POST['unblock'])) {
    
    $url = $_POST['unblock'];
    $query = "DELETE FROM blocks WHERE id_block = :id_blocked";

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':id_blocked', $_POST['unblock']);

    $stmt -> execute();

    if ($stmt) {
        echo"Sucess unblocking";
    }

} elseif (isset($_POST['block']) && is_numeric($_POST['block'])) {

    $url = $_POST['block'];
    $query = "INSERT INTO blocks VALUES(DEFAULT, :user_blocked, DEFAULT, :fk_user);
              DELETE FROM follows WHERE user_followed = :user_blocked AND fk_user = :fk_user;";

    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_blocked', $_POST['block']);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser']);
    $stmt -> bindValue(':user_blocked', $_POST['block']);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser']);

    $stmt -> execute();

    if ($stmt) {
        echo"Sucess blocking";
    }
}
