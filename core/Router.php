<?php

namespace App\core;

class Router
{
    public array $routes = [];

    public function get($path, $callback)
    {
        $this->routes[$path] = $callback;
    }

    public function resolve() {
        $path = $_SERVER['REQUEST_URI'];
        $callback = $this->routes[$path];
        return call_user_func($callback);
    }
}
