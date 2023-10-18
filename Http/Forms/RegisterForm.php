<?php

namespace Http\Forms;

use Core\Validator;

class RegisterForm extends Validator
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function validateForm()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ];

        parent::validate($rules);

        return $this;
    }

    public function messages()
    {
        return [
            'name' => [
                'required' => 'The name field is required.'
            ],
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email field must be a valid email address.',
                'unique' => 'The email address is already in use.'
            ],
        ];
    }
}