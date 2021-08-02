<?php

session_start();

include('config.php');
require('../database/connect.php');
require('../php/functions.php');

if(isset($_POST['id_token'])) {

    $jwt = new \Firebase\JWT\JWT; //https://github.com/googleapis/google-api-php-client/issues/1172
    $jwt::$leeway = 5;

    $id_token = cleanString($_POST['id_token']);

    if (empty($id_token) || is_null($id_token)){
        echo "Error in ID_Token sanitization";
        exit();
    }

    $payload = $google_client->verifyIdToken($id_token);
    
    if ($payload) {

        // Return all user data in a JSON
        $json = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=".$id_token);
        $data = json_decode($json);

        // Get profile info
        $email_user = $data->email;

        $query = "SELECT id_user, user_email, user_password, auth_type, darkmode FROM users WHERE user_email = :email_user";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':email_user', $email_user);

        $stmt -> execute();

        $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);
 
        if ( $stmt -> rowCount() > 0) {

            if ($return[0]['user_email'] == $email_user && $return[0]['auth_type'] == 'GOOGLE' && $return[0]['user_password'] == $data->sub) {

                $_SESSION['isAuth'] = true;

                if ($return[0]['darkmode']) {
                    $_SESSION['darkMode'] = 'dark';
                } else {
                    $_SESSION['darkMode'] = 'light';
                }
                
                $_SESSION['idUser'] = $return[0]['id_user'];
                $_SESSION['authType'] = 'GOOGLE';
                
                echo "Sucess";
                exit();

            } else {
                echo "Error checking you account register";
                exit();
            }  

        } else {

            $query = "INSERT INTO users VALUES(DEFAULT, :name_user , :email_user , :password_user, 'GOOGLE', 
                  DEFAULT, :picture_user , NULL, DEFAULT, DEFAULT, DEFAULT, DEFAULT)";

            $stmt = $conn -> prepare($query);

            $stmt -> execute( array(':name_user' => $data->name ,
                                    ':email_user' => $data->email,
                                    ':password_user' => $data->sub,
                                    ':picture_user' => $data->picture) );

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
                $_SESSION['idUser'] = $return['id_user'];
                $_SESSION['authType'] = 'GOOGLE';

                echo "Sucess";
            }

        }
    }

} else {
    echo "Something went Wrong with you ID";
}
    
