<?php



require_once("../database/connect.php");
require_once("functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if (isset($_POST['unblock']) && !is_numeric($_POST['unblock'])) {
    
    if (!is_numeric(decodeId($_POST['unblock']))) {
        exit;
    }

    $query = "DELETE FROM blocks WHERE user_blocked = :id_blocked AND fk_user = :session_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_blocked', decodeId($_POST['unblock']), PDO::PARAM_INT);
    $stmt -> bindValue(':session_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();

    if ($stmt && $stmt -> rowCount() == 1) {
        echo"Sucess unblocking";
    }

} elseif (isset($_POST['block']) && !is_numeric($_POST['block'])) {

    if (!is_numeric(decodeId($_POST['block']))) {
        exit;
    }

    $query = "INSERT INTO blocks VALUES(DEFAULT, :user_blocked, DEFAULT, :fk_user);
              DELETE FROM follows WHERE user_followed = :user_blocked AND fk_user = :fk_user;";

    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_blocked', decodeId($_POST['block']), PDO::PARAM_INT);
    $stmt -> bindValue(':fk_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':user_blocked', decodeId($_POST['block']), PDO::PARAM_INT);
    $stmt -> bindValue(':fk_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();

    if ($stmt && $stmt -> rowCount() > 1) {
        echo"Sucess blocking";
    }
}
