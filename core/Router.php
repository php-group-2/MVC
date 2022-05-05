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
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $func = $this->routes[$method][$path] ?? false;
        if ($func === false) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        if (is_string($func)) {
            return $this->renderView($func);
        }

        return $func();
        // return call_user_func($callback);
    }

    public function renderView($view)
    {
        $layout = $this->renderLayout();
        $content = $this->renderContent($view);
        return str_replace("{{content}}", $content, $layout);
    }

    public function renderLayout()
    {
        ob_start();
        include_once Application::$ROOT . "/view/layout/main.php";
        return ob_get_clean();
    }

    public function renderContent($view)
    {
        ob_start();
        include_once Application::$ROOT . "/view/$view.php";
        return ob_get_clean();
    }
}
