<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)
            ->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                //dd($user);
                $this->login([
                    'email' => $email,
                    'id' => $user['id'],
                ]);

                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'authType' => "PASSWORD",
            'theme' => 'dark',
        ];
        
        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}