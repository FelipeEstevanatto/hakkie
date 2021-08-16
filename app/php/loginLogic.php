<?php

session_start();

require_once("../database/connect.php");
require_once("functions.php");

$email_user = cleanEmail( $_POST['email'] );
$password_user = cleanString($_POST['password']);

if ($email_user !== false && !empty($password_user) && isset($_POST['login-user-submit']) ) {

    $dbpassword = generateFakePassword();

    $query = "SELECT id_user, user_email, user_password, auth_type, darkmode FROM users WHERE user_email = :email_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) > 0) {

        if ($return[0]['auth_type'] == 'GOOGLE'){
            header("Location: ../../public/views/login.php?error=invalid");
            exit();
        }
        
        $password_user = cleanString($_POST['password']);
        $dbpassword = $return[0]['user_password'];
        
    }

    if ( password_verify($password_user, $dbpassword) && count($return) > 0 ) {

        session_regenerate_id(true);

        $_SESSION['isAuth'] = true;

        if ($return[0]['darkmode']) {
            $_SESSION['darkMode'] = 'dark';
        } else {
            $_SESSION['darkMode'] = 'light';
        }
        
        $_SESSION['idUser'] = $return[0]['id_user'];
        $_SESSION['authType'] = 'PASSWORD';

        if (isset($_COOKIE['resumeP'])) {
            header("Location: ../../public/views/post.php?id=".$_COOKIE['resumeP']);
            setcookie("resumeP", "", -1 , "/");
            exit();
        } else if (isset($_COOKIE['resumeU'])) {
            header("Location: ../../public/views/user.php?user=".$_COOKIE['resumeU']);
            setcookie("resumeU", "", -1 , "/");
            exit();
        }

        header("Location: ../../public/views/home.php");
        exit();

    } else {
        header("Location: ../../public/views/login.php?error=invalid");
        exit();
    }

} else {
    header("Location: ../../public/views/login.php?error=emptyfiels");
    exit();
}
