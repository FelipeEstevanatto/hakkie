<?php

namespace Core;

use Core\App;
use Core\Database;
use Core\ValidationException;

class Validator
{
    protected $data;
    protected $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate($rules)
    {
        foreach ($rules as $field => $rule) {
            $rules = explode('|', $rule);
    
            foreach ($rules as $rule) {
                $value = isset($this->data[$field]) ? $this->data[$field] : null;
    
                $args = explode(':', $rule);
                $ruleName = $args[0];
                $ruleArgs = isset($args[1]) ? explode(',', $args[1]) : [];
    
                switch ($ruleName) {
                    case 'required':
                        if (empty($value)) {
                            $this->addError($field, 'The ' . $field . ' field is required.', 'required');
                        }
                        break;
    
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($field, 'The ' . $field . ' field must be a valid email address.', 'email');
                        }
                        break;
    
                    case 'min':
                        if (strlen($value) < $ruleArgs[0]) {
                            $this->addError($field,  'The ' . $field . ' field must be at least ' . substr($rule, 4) . ' characters.', 'min');
                        }
                        break;

                    case 'max':
                        if (strlen($value) > $ruleArgs[0]) {
                            $this->addError($field, 'The ' . $field . ' field must be less than ' . substr($rule, 4) . ' characters.', 'max');
                        }
                        break;

                    case 'unique':
                        $this->unique($field, $ruleArgs[0], isset($ruleArgs[1]) ? $ruleArgs[1] : 'id');
                        break;

                    case 'matches':
                        if ($value !== $this->data[$ruleArgs[0]]) {
                            $this->addError($field, 'The ' . $field . ' field does not match the confirmation.', 'matches');

                        }
                        break;
                    
                        case 'file':
                            if (!empty($_FILES[$field]['name'])) {
                                if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                                    $this->addError($field, 'The ' . $field . ' field must be a valid file.', 'file');
                                } else {
                                    $fileSize = $_FILES[$field]['size'];
                                    $maxSize = $ruleArgs[0] ?? 0;
        
                                    if ($maxSize > 0 && $fileSize > $maxSize) {
                                        $this->addError($field, 'The ' . $field . ' field must be smaller than ' . $maxSize . ' bytes.', 'file');
                                    }
        
                                    $fileType = $_FILES[$field]['type'];
                                    $allowedTypes = $ruleArgs[1] ?? [];
        
                                    if (!empty($allowedTypes) && !in_array($fileType, $allowedTypes)) {
                                        $this->addError($field, 'The ' . $field . ' field must be a valid file type.', 'file');
                                    }
                                }
                            } elseif ($ruleName !== 'nullable' && empty($_FILES[$field]['name'])) {
                                $this->addError($field, 'The ' . $field . ' field is required.', 'required');
                            }
                            break;
        
                        case 'nullable':
                            if (empty($_FILES[$field]['name']) || empty($value)) {
                                break 2;
                            }
                            break;
        
                        case 'files':
                            if (empty($_FILES[$field]['name'])) {
                                if ($ruleName !== 'nullable') {
                                    $this->addError($field, 'The ' . $field . ' field is required.', 'required');
                                } else {
                                    break 2;
                                }
                            } else {
                                $this->files($field, $ruleArgs[0]);
                            }
                            break;
        
                        case 'images':
                            if (!empty($_FILES[$field]['name'])) {
                                $this->images($field, $ruleArgs[0]);
                            } elseif ($ruleName !== 'nullable' && empty($_FILES[$field]['name'])) {
                                $this->addError($field, 'The ' . $field . ' field is required.', 'required');
                            }
                            break;
                }
            }
        }
    
        return $this;
    }

    public function files($field, $size)
    {
        $files = $this->data[$field];
        $totalSize = 0;

        foreach ($files['size'] as $fileSize) {
            $totalSize += $fileSize;
        }

        if ($totalSize > $size) {
            $this->addError($field, 'The ' . $field . ' field must be less than ' . $size . ' bytes.', 'files');
        }

        return $this;
    }

    public function image($field, $formats)
    {
        $files = $this->data[$field];

        foreach ($files['type'] as $fileType) {
            $temparray = explode("/",$fileType);
            $extension = strtolower(end($temparray));

            if (!in_array($extension, $formats)) {
                $this->addError($field, 'The ' . $field . ' field must be an image.', 'image');
            }
        }

        return $this;
    }

    public function unique($field, $table, $column = 'id')
    {
        $value = $this->data[$field];
        if (!empty($value)) {
            $db = App::resolve(Database::class);

            $result = $db->query("SELECT * FROM {$table} WHERE {$column} = :{$column}", [
                $column => $value
            ])->find();

            if ($result) {
                $this->addError($field, 'The ' . $field . ' field must be unique.', 'unique');
            }
        }

        return $this;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    protected function addError($field, $message, $rule = null)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
    
        $customMessage = $this->getCustomMessage($field, $rule);

        if ($customMessage) {
            $message = $customMessage;
        }
    
        $this->errors[$field][] = $message;
    }

    protected function getCustomMessage($field, $rule)
    {
        $messages = $this->messages();

        if (isset($messages[$field]) && isset($messages[$field][$rule])) {
            return $messages[$field][$rule];
        }

        return null;
    }

    /**
     * Return custom error messages
     * return [
     *    'field' => [
     *       'rule' => 'message'
     *   ]
     * ];
     */
    public function messages()
    {
        return [];
    }
}