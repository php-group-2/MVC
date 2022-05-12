<?php

namespace App\core;

class Router
{
    public array $routes = [];
    public View $view;
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->view = new View;
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
        $callback = $this->routes[$method][$path];

        // Route not found
        if (is_null($callback)) {
            $this->response->setStatusCode(404);
            return Application::$app->view->renderView("_404");
        }

        // View
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
            Application::$app->controller = $callback[0];
        }

        // function or method
        return call_user_func($callback, $this->request, $this->response);
    }
}
