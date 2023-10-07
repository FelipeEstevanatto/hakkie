<?php

namespace Http\Controllers\post;

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['unblock']) && is_numeric($_POST['unblock'])) {

    $return = $db->query('DELETE FROM blocks WHERE user_blocked = :id_blocked AND fk_user = :session_user', [
        'id_blocked' => $_POST['unblock'],
        'session_user' => $_SESSION['user']['id']
    ]);

    if ($return) {
        echo"Sucess unblocking";
    }

} elseif (isset($_POST['block']) && is_numeric($_POST['block'])) {

    $return = $db->query('INSERT INTO blocks VALUES(DEFAULT, :user_blocked, DEFAULT, :fk_user); DELETE FROM follows WHERE user_followed = :user_blocked AND fk_user = :fk_user;',[
        'user_blocked' => $_POST['block'],
        'fk_user' => $_SESSION['user']['id'],
        'user_blocked' => $_POST['block'],
        'fk_user' => $_SESSION['user']['id']
    ]);

    if ($return) {
        echo"Sucess blocking";
    }
}
