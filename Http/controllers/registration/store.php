<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\Authenticator;
use Core\Session;

$db = App::resolve(Database::class);

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$validator = new Validator([
    'name' => $name,
    'email' => $email,
    'password' => $password
]);

$validator->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8'
]);

if ($validator->hasErrors()) {
    // handle validation errors here
    $errors = $validator->errors();

    Session::put('errors', $errors);
    header('location: /hakkie');

} else {
    // form data is valid, process it here
    $db->query('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)', [
        'username' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    (new Authenticator)->login($user);

    header('location: home');
    exit();
}