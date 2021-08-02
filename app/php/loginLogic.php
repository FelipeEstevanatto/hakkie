<?php

session_start();

require_once("../database/connect.php");
require_once("functions.php");

$email_user = cleanEmail( $_POST['email'] );
$password_user = cleanString($_POST['password']);

if ($email_user !== false && !empty($password_user) && isset($_POST['login-user-submit']) ) {

    $dbpassword = generateFakePassword();

    $query = "SELECT id_user, user_email, user_password, darkmode FROM users WHERE user_email = :email_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ( count($return) > 0) {
        
        $password_user = cleanString($_POST['password']);
        $dbpassword = $return['user_password'];
        
    }

    if ( password_verify($password_user, $dbpassword) && count($return) > 0 ) {

        session_regenerate_id(true);

        $_SESSION['isAuth'] = true;

        if ($return['darkmode']) {
            $_SESSION['darkMode'] = 'dark';
        } else {
            $_SESSION['darkMode'] = 'light';
        }
        
        $_SESSION['idUser'] = $return['id_user'];
        $_SESSION['authType'] = 'PASSWORD';

        header("Location: ../../public/views/home.php");
        exit();

    } else {
        header("Location: ../../public/views/login.php?error=invalid");
        exit();
    }

} else {
    header("Location: ../../index.php");
    exit();
}
