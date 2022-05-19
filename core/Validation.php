<?php

namespace App\core;

class Validation
{
    private static $instance = null;
    public ?array $data;
    public ?array $rules;

    private function __construct()
    {
    }

    public static function make()
    {
        if (self::$instance === null) {
            self::$instance = new Validation();
        }

        return self::$instance;
    }

    public function rules($rules)
    {
        $this->rules = $rules;
        return self::$instance;
    }

    public function setData($data)
    {
        $this->data = $data;
        return self::$instance;
    }

    public function validate()
    {
        $errors = [];
        foreach ($this->rules as $attr => $conditions) {
            $input = $this->data[$attr];
            if (is_array($conditions)) {
                foreach ($conditions as $condition) {
                    if (is_string($condition) && method_exists($this, $condition)) {
                        $result = call_user_func([$this, $condition], $input);
                        
                        if (!is_null($result)) {
                            $errors[$attr][] = $result;
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function required(string $input)
    {
        if (!$input || strlen($input) === 0)
            return 'this field is requeired';

        return null;
    }

    public function email(string $input)
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL))
            return 'It\'s not valid email';

        return null;
    }
}
