<?php

session_start();

require_once("../database/connect.php");
require_once("functions.php");

$email_user = filter_var(strtolower( cleanString($_POST['email']) ),FILTER_SANITIZE_EMAIL);
$password_user = cleanString($_POST['password']);

if (!empty($email_user) && !empty($password_user) && isset($_POST['login-user-submit']) ) {

    $dbpassword = generateFakePassword();

    $query = "SELECT id_user, email_user, user_password FROM users WHERE email_user = :email_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) > 0) {
        
        $password_user = cleanString($_POST['password']);
        $dbpassword = $return[0]['user_password'];
        
    }

    if ( password_verify($password_user, $dbpassword) && count($return) > 0 ) {

        session_regenerate_id(true);

        $_SESSION['isAuth'] = true;
        $_SESSION['idUser'] = $return[0]['id_user'];

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