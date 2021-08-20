<?php

session_start();

require_once("../../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Like
if (isset($_POST['like']) && is_numeric($_POST['like'])) {

    $query = 'INSERT INTO likes VALUES(DEFAULT, :id_post , DEFAULT, :id_user) ON CONFLICT DO NOTHING;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', $_POST['like'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    
    $stmt -> execute();
 
    if ($stmt) {
        echo"1";
    }

} else if (isset($_POST['unlike']) && is_numeric($_POST['unlike'])) {

    $query = 'DELETE FROM likes WHERE fk_like_owner = :id_user AND fk_post = :id_post;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', $_POST['unlike'], PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0";
    }

}