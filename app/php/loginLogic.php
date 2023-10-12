<?php

require_once(__DIR__ . '/../../bootstrap.php');
require_once(__DIR__."/functions.php");

$email_user = cleanEmail( $_POST['email'] );
$password_user = cleanString($_POST['password']);

if ($email_user !== false && !empty($password_user) && isset($_POST['login-user-submit']) ) {

    $dbpassword = generateFakePassword();

    $query = "SELECT id, email, password, auth_type, darkmode FROM users WHERE email = :email_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) > 0) {

        if ($return[0]['auth_type'] == 'GOOGLE'){
            header("Location: login?error=invalid");
            exit();
        }
        
        $password_user = cleanString($_POST['password']);
        $dbpassword = $return[0]['password'];
        
    }

    if ( password_verify($password_user, $dbpassword) && count($return) > 0 ) {

        session_regenerate_id(true);

        $_SESSION['isAuth'] = true;

        $theme = $return[0]['darkmode'] ? 'dark' : 'light';
        setcookie("darkMode", $theme, 2147483647, "/");
        
        $_SESSION['idUser'] = encodeId($return[0]['id']);
        $_SESSION['authType'] = 'PASSWORD';

        if (isset($_COOKIE['resumeP'])) {
            header("Location: post?id=".$_COOKIE['resumeP']);
            setcookie("resumeP", "", -1 , "/");
            exit();
        } else if (isset($_COOKIE['resumeU'])) {
            header("Location: user?user=".$_COOKIE['resumeU']);
            setcookie("resumeU", "", -1 , "/");
            exit();
        }

        header("Location: home");
        exit();

    } else {
        header("Location: login?error=invalid");
        exit();
    }

} else {
    header("Location: login?error=emptyfiels");
    exit();
}
