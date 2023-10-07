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
            'post-text' => 'required|max:256',
            'uploadfile' => 'nullable|files:400000|image:jpeg,jpg,png,gif,mp4,webm,mov',
        ];

        parent::validate($rules);

        return $this;
    }

    public function messages()
    {
        return [
            'post-text' => [
                'required' => 'The post text field is required.',
                'max' => 'The post text field must be less than 256 characters.'
            ],
            'uploadfile' => [
                'file' => 'The uploadfile field must be a file.',
                'image' => 'The uploadfile field must be an image.',
            ]
        ];
    }
}