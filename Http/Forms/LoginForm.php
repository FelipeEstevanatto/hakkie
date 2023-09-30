<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm extends Validator
{
    protected $errors = [];

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function validateForm()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        parent::validate($rules);

        return $this;
    }
}