<?php

namespace Http\controllers;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$return = $db->query('SELECT username, email, password, user_info FROM users WHERE id = :id',[
    'id' => $_SESSION['user']['id'],
])->find();

if ( isset($_POST['change-user-name']) ) {

    $newName = $_POST['name'];

    if (empty($newName) && strlen($newName) > 64 && $newName !== $return['username']) {
        header("Location: settings?error=invalidname");
        exit();
    }

    echo"change user name";
    $result = $db->query('UPDATE users SET username = :newname WHERE id = :id',[
        'newname' => $newName,
        'id' => $_SESSION['user']['id'],
    ]);

    if ($result == null) {
        header("Location: settings?error=invalidname");
        exit();
    }
    
} elseif ( isset($_POST['change-user-email']) ) {

    $newEmail = $_POST['email'];

    if ($newEmail === false && $newEmail !== $return['email']) {
        header("Location: settings?error=invalidemail");
        exit();
    }

    echo"change user email";
    $result = $db->query('UPDATE users SET email = :newEmail WHERE id = :id',[
        'newEmail' => $newEmail,
        'id' => $_SESSION['user']['id'],
    ]);
    
    if($result == null) {
        header("Location: settings?error=invalidemail");
        exit();
    }

} elseif ( isset($_POST['change-user-password']) ) {

    $newPass = $_POST['password'];

    if (empty($newPass) && strlen($newPass) > 255) {
        header("Location: settings?error=invalidpassword");
        exit();
    }

    $hashednewPass = password_hash($newPass, PASSWORD_BCRYPT);

    echo"change user pass";
    $result = $db->query('UPDATE users SET password = :newPass WHERE id = :id',[
        'newPass' => $hashednewPass,
        'id' => $_SESSION['user']['id'],
    ]);

    if ($result == null) {
        header("Location: settings?error=invalidpassword");
        exit();
    }
} elseif ( isset($_POST['change-user-info']) ) {

    $newInfo = $_POST['update-info'];

    if (empty($newInfo) && strlen($newInfo) > 256 && $newInfo !== $return['user_info']) {
        header("Location: settings?error=invalidpassword");
        exit();
    }

    echo"change user info";
    $result = $db->query('UPDATE users SET user_info = :newInfo WHERE id = :id',[
        'newInfo' => $newInfo,
        'id' => $_SESSION['user']['id'],
    ]);

    if ($result == null) {
        header("Location: settings?error=invalidpassword");
        exit();
    }
}

header('Location: settings?nice');
exit();