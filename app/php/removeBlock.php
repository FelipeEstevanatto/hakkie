<?php

session_start();

require_once("../database/connect.php");

if (isset($_POST['unblock'] )) {

    $query = "DELETE FROM blocks WHERE id_block = :id_blocked";

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':id_blocked', $_POST['unblock']);

    $stmt -> execute();
}
