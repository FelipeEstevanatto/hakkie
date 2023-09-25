<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;
use Http\Forms\LoginForm;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    view("login.view.php", [
        'heading' => 'Login',
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = App::resolve(Database::class);

    $form = LoginForm::validate($attributes = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ]);

    $signedIn = (new Authenticator)->attempt(
        $attributes['email'], $attributes['password']
    );

    if (!$signedIn) {
        $form->error(
            'email', 'No matching account found for that email address and password.'
        )->throw();
    }

    

    redirect('home');
}