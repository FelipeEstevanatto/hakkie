<?php



require_once(__DIR__."functions.php");
require_once(__DIR__."/../../bootstrap.php");

if (isset($_POST['new-password-submit'])) {
    
    $selector = $_POST['selector'];
    $validator = $_POST['validator']; //token
    $new_password = cleanString($_POST['password']);
    $passwordRepeat = cleanString($_POST['password-repeat']);

    if ( empty($new_password) || empty($passwordRepeat) ) {
        header("location: new-password?selector=$selector&validator=$validator&newpwd=empty");
        exit();
    } else if ( $new_password !== $passwordRepeat ) {
        header("location: new-password?selector=$selector&validator=$validator&newpwd=pwdnotsame");
        exit();
    }
    
    $currentDate = date("U");

    $query = "SELECT * FROM pwdReset WHERE pwdResetSelector = :selector AND pwdResetExpires >= :currentTime";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(":selector", $selector);
    $stmt -> bindValue(":currentTime", $currentDate);

    $stmt -> execute();

    $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if (!$stmt || count($row) != 1) {
        header("location: new-password?newpwd=error");
        exit();
    }

    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row[0]['pwdresettoken']);

    if ($tokenCheck === false) {
        header("location: new-password?newpwd=error");
        exit();
    } elseif ($tokenCheck === true) {

        $tokenEmail = $row[0]['pwdresetemail'];

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(":email", $tokenEmail);
        $stmt -> execute();

        $row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        if (!$stmt || count($row) < 1) {
            header("location: new-password?newpwd=error");
            exit();
        } else {

            $new_Password = password_hash($new_password, PASSWORD_BCRYPT);

            $query = "UPDATE users SET password = :newpassword WHERE email = :email_user";
            $stmt = $conn -> prepare($query);
            $stmt -> bindValue(":newpassword", $new_Password);
            $stmt -> bindValue(":email_user", $tokenEmail);
            $stmt -> execute();

            $query = "DELETE FROM pwdreset WHERE pwdresetemail = :email_user";
            $stmt2 = $conn -> prepare($query);
            $stmt2 -> bindValue(':email_user', $tokenEmail);
            $stmt2 -> execute();

            if ( !$stmt || !$stmt2) {
                header("location: new-password?newpwd=error");
                exit();
            } else {
                header("location: login?newpwd=passwordupdated");
                exit();
            }
        }

    }

} else { //Came from outside our form
    header("location: index");  
    exit();
}
