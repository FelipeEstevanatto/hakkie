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
                  DEFAULT, NULL, DEFAULT, DEFAULT, DEFAULT)";

        $stmt = $conn -> prepare($query);

        $stmt -> execute( array(':name_user' => $name_user ,
                                ':email_user' => $email_user,
                                ':password_user' => $password_user ) );

        if ($stmt) {

            $query = "SELECT id_user, darkmode FROM users WHERE user_email = :email_user";

            $stmt = $conn -> prepare($query);

            $stmt -> bindValue(':email_user', $email_user);

            $stmt -> execute();

            $return = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['isAuth'] = true;
            if ($return['darkmode']) {
                $_SESSION['darkMode'] = 'dark';
            } else {
                $_SESSION['darkMode'] = 'light';
            }

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
