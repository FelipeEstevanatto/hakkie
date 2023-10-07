<?php

namespace Http\Controllers\session;

use Core\Session;
use Core\Authenticator;
use Core\ValidationException;
use Http\Forms\LoginForm;
//echo "Hello World";
class SessionController {

    /**
     *  Show the login form
     */
    public function create()
    {
        return view("login.view.php", [
            'heading' => 'Login',
            'errors' => Session::get('errors'),
            'old' => Session::get('old')
        ]);
    }

    /**
     * Store the user session
     */
    public function store() {

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
    }

    /**
     *  Logout the user
     */
    public function destroy()
    {
        (new Authenticator)->logout();

        header('location: /hakkie');
        exit();
    }
}