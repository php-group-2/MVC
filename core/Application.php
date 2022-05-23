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
        include_once __DIR__ . "/helpers/helper.php";
        include_once __DIR__ . "/helpers/response.php";

        Session::start();

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
        return $this;
    }

    public function post($path, $callback)
    {
        $this->router->post($path, $callback);
        return $this;
    }

    public function delete($path, $callback)
    {
        $this->router->delete($path, $callback);
        return $this;
    }

    public function middleware($middlwareName)
    {
        $this->router->middleware($middlwareName);
    }

    public function put($path, $callback)
    {
        $this->router->put($path, $callback);
        return $this;
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
