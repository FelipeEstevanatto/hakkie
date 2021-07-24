<?php

session_start();

require_once("../database/connect.php");
require_once("functions.php");

$email_user = cleanEmail( $_POST['email'] );
$password_user = cleanString($_POST['password']);

if (!empty($email_user) && !empty($password_user) && isset($_POST['login-user-submit']) ) {

    $dbpassword = generateFakePassword();

    $query = "SELECT id_user, email_user, user_password, darkmode FROM users WHERE email_user = :email_user";

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
        $_SESSION['darkMode'] = $return['darkmode'];
        $_SESSION['idUser'] = $return['id_user'];

        header("Location: ../../public/views/home.html");
        exit();

    } else {
        header("Location: login.php");
        exit();
    }

} else {
    header("Location: ../../index.html");
    exit();
}
