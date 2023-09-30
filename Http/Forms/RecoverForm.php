<?php

namespace Http\Forms;

use Core\Validator;

class RecoverForm extends Validator
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function validateForm()
    {
        $rules = [
            'email' => 'required|email',
        ];

        parent::validate($rules);

        return $this;
    }

    public function message()
    {
        return [
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email field must be a valid email address.',
            ],
        ];
    }
}