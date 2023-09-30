<?php

use Core\Session;

$data_login_uri = $_ENV['GOOGLE_LOGIN_URI']."/app/google/verifyIntegrity.php" ?? 'http://localhost/hakkie/app/google/verifyIntegrity.php';

view('login.view.php', [
    'heading' => 'Login',
    'errors' => Session::get('errors'),
    'data_login_uri' => $data_login_uri,
]);