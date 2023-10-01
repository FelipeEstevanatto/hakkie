<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm([
    'email' => $email,
    'password' => $password
]);

$errors = $form->validateForm()->errors();

if ($form->hasErrors()) {
    ValidationException::throw($errors, $_POST);
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