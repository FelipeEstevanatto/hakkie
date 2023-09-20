<?php

    require_once(__DIR__."/../../bootstrap.php");
    require(__DIR__."/functions.php");

    if (isset($_COOKIE['g_csrf_token'])) {
        setcookie("g_csrf_token", null, -1);
        setcookie("g_state", null, -1);
    }

    if (isset($_COOKIE['darkMode']) && ($_COOKIE['darkMode'] === 'dark' || $_COOKIE['darkMode'] === 'light')) {
        
        $darkMode = $_COOKIE['darkMode'] === 'dark' ? true : false;
        
        $query = 'UPDATE users SET darkmode = :theme WHERE id = :id';
    
        $stmt = $conn -> prepare($query);
        
        $stmt -> bindValue(':theme', $darkMode, PDO::PARAM_BOOL);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    
        $stmt -> execute();

        setcookie("darkMode", "", -1, "/");
    }

    setcookie("resumeP", "", -1, "/");
    setcookie("resumeU", "", -1, "/");

    session_destroy();

    $conn = null;

    header('Location: /hakkie');
    exit();
