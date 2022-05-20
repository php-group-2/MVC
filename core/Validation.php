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
            $rules = is_string($conditions) ? explode("|", $conditions) : $conditions;

            foreach ($rules as $rule) {
                $limit = null;
                if (str_contains($rule, ':')) {
                    $arrayRule = explode(':', $rule);
                    $rule = $arrayRule[0];
                    $limit = $arrayRule[1];
                }
                if (method_exists($this, $rule)) {

                    $result = call_user_func([$this, $rule], $input , $limit);

                    if (!is_null($result)) {
                        $errors[$attr][] = $result;
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

    public function min($input , $limit) : ?string
    {
        if(strlen($input) < $limit){
            return 'min char is ' . $limit;
        }
        return null;
    }

    public function max($input , $limit) : ?string
    {
        if(strlen($input) > $limit){
            return 'max char is ' . $limit;
        }
        return null;
    }
}
