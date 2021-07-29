<?php

session_start();

require_once("../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if (isset($_POST['follow']) && is_numeric($_POST['follow'])) {
    
    $query = 'INSERT INTO follows VALUES(DEFAULT, :user_followed, DEFAULT, :id_user)';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_POST['follow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

    if ($stmt) {
        echo"Sucess following";
    }

} elseif (isset($_POST['unfollow']) && is_numeric($_POST['unfollow'])) {

    $query = 'DELETE FROM follows WHERE user_followed = :user_followed AND fk_user = :id_user';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_POST['unfollow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

    if ($stmt) {
        echo"Sucess unfollowing";
    }

}
