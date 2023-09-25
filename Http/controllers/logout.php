<?php

namespace Http\controllers;

use Core\App;
use Core\Database;
use Core\Authenticator;

$db = App::resolve(Database::class);

if (isset($_COOKIE['g_csrf_token'])) {
    setcookie("g_csrf_token", null, -1);
    setcookie("g_state", null, -1);
}

$db->query("UPDATE users SET darkmode = :theme WHERE id = :id_user", [
    'theme' => $_COOKIE['theme'] === 'dark' ? true : false,
    'id_user' => $_SESSION['user']['id']
]);

setcookie("theme", "", -1, "/");

setcookie("resumeP", "", -1, "/");
setcookie("resumeU", "", -1, "/");

$auth = new Authenticator;

$auth->logout();

header('Location: /hakkie');
exit();