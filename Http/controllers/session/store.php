<?php

use Core\Authenticator;
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

    ValidationException::throw($errors, $_POST);
    exit();
} else {
    header('location: home');
    exit();
}