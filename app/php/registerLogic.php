<?php

session_start();

require_once("../../vendor/autoload.php");

require_once("../database/connect.php");
require_once("functions.php");

$name_user = cleanString($_POST['name']);
$email_user = cleanEmail($_POST['email']);
$password_user = cleanString($_POST['password']);

if ($email_user !== false && !empty($password_user) && isset($_POST['register_user_submit']) ) {
    
    $query = "SELECT user_email, auth_type FROM users where user_email = :email_user ";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) == 0 ) {

        $password_user = password_hash($password_user, PASSWORD_BCRYPT);

        $query = "INSERT INTO users VALUES(DEFAULT, :name_user , :email_user , :password_user, DEFAULT, 
                  DEFAULT, NULL, DEFAULT, DEFAULT, DEFAULT) RETURNING id_user, darkmode;";

        $stmt = $conn -> prepare($query);

        $stmt -> execute( array(':name_user' => $name_user ,
                                ':email_user' => $email_user,
                                ':password_user' => $password_user ) );

        if ($stmt) {

            $return = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['isAuth'] = true;

            $theme = $return['darkmode'] ? 'dark' : 'light';
            setcookie("darkMode", $theme, 2147483647, "/");

            $_SESSION['authType'] = 'PASSWORD';
            $_SESSION['idUser'] = encodeId($return['id_user']);

            header("Location: ../../public/views/home.php");
            exit();
        }
    } elseif($return['auth_type'] == 'GOOGLE'){
        header("Location: ../../index.php?error=googleemailalreadyregistered");
        exit();
    } else {
        header("Location: ../../index.php?error=emailalreadyregistered");
        exit();
    }

} else { 
    header("Location: ../../index.php?error=emptyfields");
    exit();
}
