<?php

namespace Http\Controllers\registration;

use Core\Session;
use Core\Database;
use Core\Authenticator;
use Http\Forms\RegisterForm;
use Core\ValidationException;

class RegistrationController {
    public function create() {
        return view("registration.create.view.php", [
            'heading' => 'Hakkie - Register',
            'errors' => Session::get('errors'),
            'old' => Session::get('old')
        ]);
    }

    public function store() {
        $db = App::resolve(Database::class);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $form = new RegisterForm([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $errors = $form->validateForm()->errors();

        if ($form->hasErrors()) {
            ValidationException::throw($errors, $_POST);
            exit();
        }

        // Save the user data to the database
        $db->query('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)', [
            'username' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        $user = $db->query('SELECT id FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        (new Authenticator)->login([
            'email' => $email,
            'id' => $user['id'],
        ]);

        header('location: home');
        exit();
    }
}