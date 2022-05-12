<?php

namespace App\core;

class Request
{

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getPath()
    {
        // Solution 2
        return explode('?', $_SERVER['REQUEST_URI'] ?? '/')[0];

        // Long Solution
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $position = strpos($path, '?'); # uri/contact?name=navid
        if ($position === false) {
            return $path; # uri/contact
        }
        return substr($path, 0, $position);
    }

    public function isPost()
    {
        return $this->getMethod() === "post";
    }

    public function isGet()
    {
        return $this->getMethod() === "get";
    }

    public function getBody()
    {
        // Lazy Solution
        // return $_REQUEST;

        $data = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        // \htmlspecialchars()
        if ($this->getMethod() === "post") {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }

        return $data;
    }

    public function get(string $key)
    {
        return $_REQUEST[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return key_exists($key, $_REQUEST);
    }

    public function all()
    {
        return $_REQUEST;
    }

    public function param(string $key)
    {
        return $_GET[$key];
    }
}
