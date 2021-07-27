<?php

    session_start();

    require("functions.php");

    if (!isset($_SESSION['isAuth'])) {
        header("Location: ../../public/views/login.php?error=expiredsession");
        exit();
    }

    print_r($_POST);
    if ( isset($_POST['change-user-name']) ) {

        $newName = cleanString($_POST['name']);

        if (empty($newName) && strlen($newName) > 64) {
            header("Location: ../../public/views/settings.php?error=invalidname");
            exit();
        }

        echo"change user name";
        
    }

    if ( isset($_POST['change-user-email']) ) {

        $newEmail = cleanEmail($_POST['email']);

        if ($newEmail === false) {
            header("Location: ../../public/views/settings.php?error=invalidemail");
            exit();
        }
        echo"change user email";
    }

    if ( isset($_POST['change-user-password']) ) {

        $newPass = cleanString($_POST['password']);

        if (empty($newPass) && strlen($newPass) > 255) {
            header("Location: ../../public/views/settings.php?error=invalidpassword");
            exit();
        }

        echo"change user pass";
    }
