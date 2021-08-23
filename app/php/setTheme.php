<?php

session_start();

require_once("../database/connect.php");

if (isset($_POST['theme'] )) {
    if ($_POST['theme'] == 'dark') {
        $query = "UPDATE users SET darkmode = TRUE WHERE id_user = :id_user";

        $_SESSION['darkMode'] = 'dark';
    } else if ($_POST['theme'] == 'light') {
        $query = "UPDATE users SET darkmode = FALSE WHERE id_user = :id_user";

        $_SESSION['darkMode'] = 'light';
    }

    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();
}
