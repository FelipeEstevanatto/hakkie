<?php

namespace Http\Controllers\registration\recover;

use Core\App;
use Core\Session;
use Core\Database;
use Core\ValidationException;
use Google\Service\Datastream\Validation;
use Http\Forms\RecoverForm;
use Http\Services\Mailer;

class RecoverController {

    public function index() {
        return view("recover.view.php", [
            'heading' => 'Recover',
            'errors' => Session::get('errors'),
            'old' => Session::get('old')
        ]);
    }

    public function store() {
        $db = App::resolve(Database::class);

        $email = $_POST['email'];
        $sender_ip = $_POST['sender-ip'];

        $form = new RecoverForm([
            'email' => $email,
            'sender-ip' => $sender_ip,
        ]);

        $errors = $form->validateForm()->errors();

        if ($form->hasErrors()) {
            ValidationException::throw($errors, $_POST);
            exit();
        }

        $user = $db->query('SELECT id, username, email, auth_type FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user == null) {
            $errors = [
                'email' => ['This email does not exist in our records.']
            ];

            ValidationException::throw($errors, $_POST);
            exit();
        }

        if ($user['auth_type'] == 'GOOGLE') {
            $errors = [
                'email' => ['This email is associated with a Google account.']
            ];
            ValidationException::throw($errors, $_POST);
            exit();
        }

        $username = $user['username'];
        $ipDetails = getUserIP();
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $hashedToken = password_hash($token, PASSWORD_BCRYPT);

        $url = 'http://'.$_SERVER['HTTP_HOST'].'/hakkie/public/views/';
        $url .= 'new-password?selector=' . $selector . '&validator='. bin2hex($token);

        $db->query('INSERT INTO pwdreset (ipRequest, cityRequest, regionRequest, countryRequest, email, selector, token, expires) VALUES (:ipRequest, :cityRequest, :regionRequest, :countryRequest, :email, :selector, :token, :expires)', [
            'ipRequest' => $ipDetails->ip,
            'cityRequest' => $ipDetails->city ?? '',
            'regionRequest' => $ipDetails->region ?? '',
            'countryRequest' => $ipDetails->country ?? '',
            'email' => $email,
            'selector' => $selector,
            'token' => $hashedToken,
            'expires' => date("U") + 3600
        ]);

        $link = $_ENV['BASE_URL'] . 'new-password?selector=' . $selector . '&validator=' . bin2hex($token);

        $message = "Hello, " . $user['username'] . "!\n\nYou have requested a password reset for your account. Please click the link below to reset your password:\n\n" . $link . "\n\nIf you did not request a password reset, please ignore this email.\n\nRegards,\n\nThe Social Network Team";

        $mailer = new Mailer();

        $mailer->send($user['email'], "Password Reset", $message);

        header('location: /hakkie');
        exit();
    }

    public function show($token) {
        $db = App::resolve(Database::class);

        $reset = $db->query('SELECT * FROM pwdreset WHERE token = :token', [
            'token' => $token
        ])->find();

        if ($reset == null) {
            $errors = [
                'token' => ['This token does not exist in our records.']
            ];

            ValidationException::throw($errors, $_POST);
            exit();
        }

        return view("reset.view.php", [
            'heading' => 'Reset',
            'token' => $token,
            'errors' => Session::get('errors'),
            'old' => Session::get('old')
        ]);
    }

    public function update($token) {
        $db = App::resolve(Database::class);

        $reset = $db->query('SELECT * FROM pwdreset WHERE token = :token', [
            'token' => $token
        ])->find();

        if ($reset == null) {
            $errors = [
                'token' => ['This token does not exist in our records.']
            ];

            ValidationException::throw($errors, $_POST);
            exit();
        }

        $form = new ResetForm([
            'password' => $_POST['password'],
            'password_confirmation' => $_POST['password_confirmation']
        ]);

        $errors = $form->validateForm()->errors();

        if ($form->hasErrors()) {
            ValidationException::throw($errors, $_POST);
            exit();
        }

        $db->query('UPDATE users SET password = :password WHERE id = :id', [
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'id' => $reset['fk_user']
        ]);

        $db->query('DELETE FROM pwdreset WHERE token = :token', [
            'token' => $token
        ]);

        header('location: /');
        exit();
    }

}