<?php

session_start();

require_once("../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if (isset($_POST['follow']) && is_numeric($_POST['follow'])) {

    $query = 
        'DO
        $do$
        BEGIN
            IF (NOT EXISTS(SELECT * FROM follows WHERE fk_user = :id_user AND user_followed = :user_followed)) THEN
                INSERT INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id_user);
            END IF;
        END
        $do$';
    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':user_followed', $_POST['follow'], PDO::PARAM_INT);
    $stmt -> bindValue(':user_followed', $_POST['follow'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"1";
    }

} elseif (isset($_POST['unfollow']) && is_numeric($_POST['unfollow'])) {

    $query = 'DELETE FROM follows WHERE user_followed = :user_followed AND fk_user = :id_user';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_POST['unfollow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0";
    }

}

$conn = null;
