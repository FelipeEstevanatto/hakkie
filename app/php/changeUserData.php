<?php

    

    require_once(__DIR__."/../../bootstrap.php");
    require(__DIR__."/functions.php");

    $query = "SELECT username, email, password, user_info FROM users WHERE id = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
    $stmt -> execute();
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ( isset($_POST['change-user-name']) ) {

        $newName = cleanString($_POST['name']);

        if (empty($newName) && strlen($newName) > 64 && $newName !== $return['username']) {
            header("Location: settings?error=invalidname");
            exit();
        }

        echo"change user name";
        $query = 'UPDATE users SET username = :newname WHERE id = :id';
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newname', $newName);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
        
    } elseif ( isset($_POST['change-user-email']) ) {

        $newEmail = cleanEmail($_POST['email']);

        if ($newEmail === false && $newEmail !== $return['email']) {
            header("Location: settings?error=invalidemail");
            exit();
        }

        echo"change user email";
        $query = "UPDATE users SET email = :newEmail WHERE id = :id";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newEmail', $newEmail);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    } elseif ( isset($_POST['change-user-password']) ) {

        $newPass = cleanString($_POST['password']);

        if (empty($newPass) && strlen($newPass) > 255) {
            header("Location: settings?error=invalidpassword");
            exit();
        }

        $hashednewPass = password_hash($newPass, PASSWORD_BCRYPT);

        echo"change user pass";
        $query = "UPDATE users SET password = :newPass WHERE id = :id";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newPass', $hashednewPass);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    } elseif ( isset($_POST['change-user-info']) ) {

        $newInfo = cleanString($_POST['update-info']);

        if (empty($newInfo) && strlen($newInfo) > 256 && $newInfo !== $return['user_info']) {
            header("Location: settings?error=invalidpassword");
            exit();
        }

        echo"change user info";
        $query = "UPDATE users SET user_info = :newInfo WHERE id = :id";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':newInfo', $newInfo);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    }

    $stmt -> execute();
    if ($stmt) {
        header("Location: settings?nice");
        exit();
    }
    
