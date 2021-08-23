<?php

session_start();

require_once("../../database/connect.php");
require_once("../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Follow
if (isset($_POST['follow']) && !is_numeric($_POST['follow'])) {

    if (!is_numeric(decodeId($_POST['follow']))) {
        exit;
    }

    $query = 'INSERT INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id_user) ON CONFLICT DO NOTHING;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"1Sucess";
    }

//Unfollow
} elseif (isset($_POST['unfollow']) && !is_numeric($_POST['unfollow'])) {

    if (!is_numeric(decodeId($_POST['unfollow']))) {
        exit;
    }

    $query = 'DELETE FROM follows WHERE user_followed = :user_unfollowed AND fk_user = :id_user;';

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_unfollowed', decodeId($_POST['unfollow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0Sucess";
    }

}

$conn = null;
