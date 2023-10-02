<?php

namespace Http\controllers;

use Core\Session;

$google_uri = $_ENV['GOOGLE_LOGIN_URI'];
$google_client_id = $_ENV['GOOGLE_CLIENTID'];

view("index.view.php", [
    'heading' => 'Home',
    'errors' => Session::get('errors'),
    'old' => Session::get('old'),
    'google_uri' => $google_uri,
    'google_client_id' => $google_client_id
]);