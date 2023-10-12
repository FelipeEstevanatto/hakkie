<?php

require_once(__DIR__."/../../bootstrap.php");
require(__DIR__."/functions.php");

$username = cleanString($_POST['name']);
$email_user = cleanEmail($_POST['email']);
$password_user = cleanString($_POST['password']);

if ($email_user !== false && !empty($password_user) && isset($_POST['register_user_submit']) ) {
    
    $query = "SELECT email, auth_type FROM users where email = :email_user ";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':email_user', $email_user);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) == 0 ) {

        $password_user = password_hash($password_user, PASSWORD_BCRYPT);

        $query = "INSERT INTO users VALUES(DEFAULT, :username , :email_user , :password_user, DEFAULT, 
                  DEFAULT, NULL, DEFAULT, DEFAULT, DEFAULT); "
                  ."SELECT id, darkmode FROM users WHERE email = :email_user;";

        $stmt = $conn -> prepare($query);

        $stmt -> execute( array(':username' => $username ,
                                ':email_user' => $email_user,
                                ':password_user' => $password_user ) );

        if ($stmt) {

            $return = $stmt -> fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['isAuth'] = true;

            $theme = $return['darkmode'] ? 'dark' : 'light';
            setcookie("darkMode", $theme, 2147483647, "/");

            $_SESSION['authType'] = 'PASSWORD';
            $_SESSION['idUser'] = encodeId($return['id']);

            header("Location: home");
            exit();
        }
    } elseif($return['auth_type'] == 'GOOGLE'){
        header("Location: /hakkie?error=googleemailalreadyregistered");
        exit();
    } else {
        header("Location: /hakkie?error=emailalreadyregistered");
        exit();
    }

} else { 
    header("Location: index?error=emptyfields");
    exit();
}
