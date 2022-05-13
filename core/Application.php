<?php

namespace App\core;

class Application
{
    public static string $ROOT;
    public static Application $app;

    public View $view;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;

    public function __construct($root_path)
    {
        self::$ROOT = $root_path;
        self::$app = $this;

        $this->view = new View;
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($this->request, $this->response);
    }

    public function get($path, $callback)
    {
        $this->router->get($path, $callback);
    }

    public function post($path, $callback)
    {
        $this->router->post($path, $callback);
    }

    public function delete($path, $callback)
    {
        // TODO : DELETE ROUTES
        $this->router->post($path, $callback);
    }

    public function show($view, $params = [])
    {
        return $this->view->renderView($view, $params);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }
}
