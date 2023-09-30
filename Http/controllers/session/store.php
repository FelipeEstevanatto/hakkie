<?php

use Core\Authenticator;
use Core\Validator;
use Core\Session;

$email = $_POST['email'];
$password = $_POST['password'];

$validator = new Validator([
    'email' => $email,
    'password' => $password
]);

$validator->validate([
    'email' => 'required|email',
    'password' => 'required'
]);

if ($validator->hasErrors()) {
    $errors = $validator->errors();

    Session::put('errors', $errors);
    header('location: /hakkie');
    exit();
}

$signedIn = (new Authenticator)->attempt(
    $email, $password
);

if (!$signedIn) {
    $errors = [
        'email' => ['These credentials do not match our records.']
    ];

    Session::put('errors', $errors);
    header('location: login');
    exit();
} else {
    header('location: home');
    exit();
}