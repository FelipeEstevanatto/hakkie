<?php

namespace Core;

use Core\App;
use Core\Database;

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
                            $this->addError($field, 'The ' . $field . ' field is required.');
                        }
                        break;
    
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($field, 'The ' . $field . ' field must be a valid email address.');
                        }
                        break;
    
                    case 'min':
                        if (strlen($value) < $ruleArgs[0]) {
                            $this->addError($field, 'The ' . $field . ' field must be at least ' . $ruleArgs[0] . ' characters long.');
                        }
                        break;
    
                    case 'unique':
                        $this->unique($field, $ruleArgs[0], isset($ruleArgs[1]) ? $ruleArgs[1] : 'id');
                        break;
                    case 'matches':
                        if ($value !== $this->data[$ruleArgs[0]]) {
                            $this->addError($field, 'The ' . $field . ' field must match the ' . $ruleArgs[0] . ' field.');
                        }
                        break;
                }
            }
        }
    
        return $this;
    }

    public function unique($field, $table, $column = 'id')
    {
        $value = $this->data[$field];
        if (!empty($value)) {
            $db = App::resolve(Database::class);

            $query = $db->query("SELECT * FROM {$table} WHERE {$column} = :{$column}", [
                $column => $value
            ]);

            $result = $query->find();

            if ($result) {
                $this->addError($field, 'The ' . $field . ' field must be unique.');
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

    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }
}