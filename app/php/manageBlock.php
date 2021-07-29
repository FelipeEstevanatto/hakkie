<?php

session_start();

require_once("../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
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
    $query = "INSERT INTO blocks VALUES(DEFAULT, :user_blocked, DEFAULT, :fk_user)";

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_blocked', $_POST['block']);
    $stmt -> bindValue(':fk_user', $_SESSION['idUser']);

    $stmt -> execute();

    if ($stmt) {
        echo"Sucess blocking";
    }
}