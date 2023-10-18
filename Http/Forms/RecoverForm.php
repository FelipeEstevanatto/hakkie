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
            'sender-ip' => 'required',
        ];

        parent::validate($rules);

        return $this;
    }

    public function messages()
    {
        return [
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email field must be a valid email address.',
            ],
            'sender-ip' => [
                'required' => 'There was an error in your request.',
            ],
        ];
    }
}