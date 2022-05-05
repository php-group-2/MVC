<?php

namespace App\core;

class Application
{
    public static string $ROOT;
    public Router $router;
    public Request $request;
    public Response $response;
    // public static Application $app;

    public function __construct($root_path)
    {
        // self::$app = $this;
        self::$ROOT = $root_path;
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
