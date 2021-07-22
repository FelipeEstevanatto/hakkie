<?php

session_start();

require_once("../database/connect.php");
require_once("functions.php");

$name_user = cleanString($_POST['name']);
$email_user = filter_var(strtolower( cleanString($_POST['email']) ),FILTER_SANITIZE_EMAIL);
$password_user = cleanString($_POST['password']);

if (!empty($email_user) && !empty($password_user) && isset($_POST['register_user_submit']) ) {
    
    $query = "SELECT email_user FROM users where email_user = :email_user ";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) == 0 ) {

        $password_user = password_hash($password_user, PASSWORD_BCRYPT);

        $query = "INSERT INTO users VALUES(DEFAULT, :name_user , :email_user , :password_user, NULL, NULL, DEFAULT, FALSE)";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':email_user', $email_user);

        $stmt -> execute( array(':name_user' => $name_user ,
                                ':email_user' => $email_user,
                                ':password_user' => $password_user ) );

        if ($stmt) {

            $query = "SELECT id_user FROM users WHERE email_user = :email_user";

            $stmt = $conn -> prepare($query);

            $stmt -> bindValue(':email_user', $email_user);

            $stmt -> execute();

            $return = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['isAuth'] = true;
            $_SESSION['idUser'] = $return['id_user'];

            header("Location: ../../public/views/home.html");
            exit();
        }
    } else {
        header("Location: ../../index22.php");
        exit();
    }

} else {
    header("Location: ../../index.php");
    exit();
}