<?php

use Core\App;
use Core\Database;
use Core\Session;
use Core\Validator;

$db = App::resolve(Database::class);

$selector = $_POST['selector'];
$validator = $_POST['validator']; //token
$new_password = $_POST['password'];
$passwordRepeat = $_POST['password-repeat'];

$formValidator = new Validator([
    'selector' => $selector,
    'validator' => $validator,
    'new_password' => $new_password,
    'passwordRepeat' => $passwordRepeat
]);

$formValidator->validate([
    'selector' => 'required',
    'validator' => 'required',
    'new_password' => 'required|min:8',
    'passwordRepeat' => 'required|min:8|matches:new_password'
]);

if ($formValidator->hasErrors()) {
    $errors = $formValidator->errors();

    Session::put('errors', $errors);
    header('location: new-password');
    exit();
}

$currentDate = date("U");

$row = $db->query('SELECT * FROM pwdReset WHERE pwdResetSelector = :selector AND pwdResetExpires >= :currentTime', [
    'selector' => $selector,
    'currentTime' => $currentDate
])->find();


if (!$row || count($row) < 1) {
    header("location: new-password?newpwd=error");
    exit();
}

$tokenBin = hex2bin($validator);
$tokenCheck = password_verify($tokenBin, $row[0]['pwdresettoken']);

if ($tokenCheck === false) {
    header("location: new-password?newpwd=error");
    exit();
} else

$tokenEmail = $row[0]['pwdresetemail'];

$row = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $tokenEmail
])->find();

if (!$row || count($row) < 1) {
    Session::put('errors', [
        'email' => ['There was an error finding your email.']
    ]);
    header("location: new-password?newpwd=error");
    exit();
}

$new_Password = password_hash($new_password, PASSWORD_BCRYPT);

$db->query('UPDATE users SET password = :new_password WHERE email = :email', [
    'new_password' => $new_Password,
    'email' => $tokenEmail
]);

$db->query('DELETE FROM pwdReset WHERE pwdResetEmail = :email', [
    'email' => $tokenEmail
]);

header("location: login?newpwd=passwordupdated");
exit();
