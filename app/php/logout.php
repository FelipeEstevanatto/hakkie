<?php

    require_once("../database/connect.php");
    require_once("functions.php");

    session_start();

    if (isset($_COOKIE['g_csrf_token'])) {
        setcookie("g_csrf_token", null, -1);
        setcookie("g_state", null, -1);
    }

    if (isset($_COOKIE['darkMode']) && ($_COOKIE['darkMode'] === 'dark' || $_COOKIE['darkMode'] === 'light')) {
        
        if ($_COOKIE['darkMode'] === 'dark') {
            $darkMode = true;
        } else {
            $darkMode = false;
        }
        
        $query = 'UPDATE users SET darkmode = :theme WHERE id_user = :id_user';
    
        $stmt = $conn -> prepare($query);
        
        $stmt -> bindValue(':theme', $darkMode, PDO::PARAM_BOOL);
        $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    
        $stmt -> execute();

        setcookie("darkMode", "", -1, "/");
    }

    setcookie("resumeP", "", -1, "/");
    setcookie("resumeU", "", -1, "/");

    session_destroy();

    $conn = null;

    header('Location: ../../index.php');
    exit();
