<?php

namespace App\core;

class Router
{
    public array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $this->request->getMethod();
        $func = $this->routes[$method][$path] ?? false;
        if ($func === false) {
            return "404: NOT FOUND!";
        }
        return $func();
        // return call_user_func($callback);
    }
}
