<?php

    session_start();

    require_once("../database/connect.php");
    require("functions.php");

    if (!isset($_SESSION['isAuth'])) {
        header("Location: ../../public/views/login.php?error=expiredsession");
        exit();
    }

    $query = "SELECT name_user, user_email, user_password, user_info FROM users WHERE id_user = :id_user";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);
    $stmt -> execute();
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ( isset($_POST['change-user-name']) ) {

        $newName = cleanString($_POST['name']);

        if (empty($newName) && strlen($newName) > 64 && $newName !== $return['name_user']) {
            header("Location: ../../public/views/settings.php?error=invalidname");
            exit();
        }

        echo"change user name";
        $query = 'UPDATE users SET name_user = :newname WHERE id_user = :id_user';
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newname', $newName);
        $stmt -> bindValue(':id_user', $_SESSION['idUser']);
        
    } elseif ( isset($_POST['change-user-email']) ) {

        $newEmail = cleanEmail($_POST['email']);

        if ($newEmail === false && $newEmail !== $return['user_email']) {
            header("Location: ../../public/views/settings.php?error=invalidemail");
            exit();
        }

        echo"change user email";
        $query = "UPDATE users SET user_email = :newEmail WHERE id_user = :id_user";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newEmail', $newEmail);
        $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    } elseif ( isset($_POST['change-user-password']) ) {

        $newPass = cleanString($_POST['password']);

        if (empty($newPass) && strlen($newPass) > 255) {
            header("Location: ../../public/views/settings.php?error=invalidpassword");
            exit();
        }

        $hashednewPass = password_hash($newPass, PASSWORD_BCRYPT);

        echo"change user pass";
        $query = "UPDATE users SET user_password = :newPass WHERE id_user = :id_user";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newPass', $hashednewPass);
        $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    } elseif ( isset($_POST['change-user-info']) ) {

        $newInfo = cleanString($_POST['update-info']);

        if (empty($newInfo) && strlen($newInfo) > 256 && $newInfo !== $return['user_info']) {
            header("Location: ../../public/views/settings.php?error=invalidpassword");
            exit();
        }

        echo"change user info";
        $query = "UPDATE users SET user_info = :newInfo WHERE id_user = :id_user";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newInfo', $newInfo);
        $stmt -> bindValue(':id_user', $_SESSION['idUser']);
    }

    $stmt -> execute();
    if ($stmt) {
        header("Location: ../../public/views/settings.php?nice");
        exit();
    }
    
