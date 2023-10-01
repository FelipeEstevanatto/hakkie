<?php

namespace Http\Forms;

use Core\Validator;

class PostForm extends Validator
{
    protected $errors = [];

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function validateForm()
    {
        $rules = [
            'post-text' => 'required|max:255',
        ];

        parent::validate($rules);

        return $this;
    }
}