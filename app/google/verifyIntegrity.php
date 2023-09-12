<?php



include(__DIR__.'/config.php');
require_once(__DIR__.'/../../bootstrap.php');
require_once(__DIR__.'/../php/functions.php');

//Verify ['g_csrf_token'] cookie, and POST id_token/credentials
if (!isset($_COOKIE['g_csrf_token']) || $_COOKIE['g_csrf_token'] !== $_POST['g_csrf_token'] || !isset($_POST['credential'])) {
    
    echo "Something went very wrong with you Login request<br>
    <a href='/login'>Back to login</a>";

} else {
    date_default_timezone_set('America/Sao_Paulo');

    $jwt = new \Firebase\JWT\JWT; //https://github.com/googleapis/google-api-php-client/issues/1172
    $jwt::$leeway = 60;

    $id_token = cleanString($_POST['credential']);

    if (empty($id_token) || is_null($id_token) && $_POST['credential'] != $id_token){
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

            if ($return[0]['user_email'] == $email_user && $return[0]['auth_type'] == 'GOOGLE' && password_verify($data->sub, $return[0]['user_password'])) {

                $_SESSION['isAuth'] = true;

                $theme = $return[0]['darkmode'] ? 'dark' : 'light';
                setcookie("darkMode", $theme, 2147483647, "/");

                $_SESSION['authType'] = 'GOOGLE';
                $_SESSION['idUser'] = encodeId($return[0]['id_user']);
                
                if (isset($_COOKIE['resumeP'])) {
                    header("Location: post?id=".$_COOKIE['resumeP']);
                    setcookie("resumeP", "", -1 , "/");
                    exit();
                } else if (isset($_COOKIE['resumeU'])) {
                    header("Location: user?user=".$_COOKIE['resumeU']);
                    setcookie("resumeU", "", -1 , "/");
                    exit();
                }

                //Home after sign in
                header("Location: home");
                exit();

            } else {
                echo "Error checking you account register";
                exit();
            }  

        } else {

            $picture = str_replace('=s96-c', '=s400-c', $data->picture);

            $query = "INSERT INTO users VALUES(DEFAULT, :name_user , :email_user , :password_user, 'GOOGLE', 
                      DEFAULT, :picture_user , DEFAULT, DEFAULT, DEFAULT) RETURNING id_user, darkmode;";

            $stmt = $conn -> prepare($query);

            $stmt -> execute( array(':name_user' => $data->name,
                                    ':email_user' => $data->email,
                                    ':password_user' => password_hash($data->sub, PASSWORD_DEFAULT),
                                    ':picture_user' => $picture) );

            if ($stmt) {

                $return = $stmt -> fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['isAuth'] = true;

                $theme = $return['darkmode'] ? 'dark' : 'light';
                setcookie("darkMode", $theme, 2147483647, "/");

                $_SESSION['authType'] = 'GOOGLE';
                $_SESSION['idUser'] = encodeId($return['id_user']);

                //Home after registering user
                header("Location: home");
                exit();
            }

        }
    }

}
    
