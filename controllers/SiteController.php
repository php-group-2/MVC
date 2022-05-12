<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;
use App\core\Response;
use App\core\View;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->setLayout('main');
    }

    public function home(Request $request)
    {
        return $this->render("home", ["todo" => []]);
    }

    public function addTodo(Request $request, Response $response)
    {
        $todo = $request->get('todo');
        $response->setStatusCode(201);
        return $this->render("Add", [
            "todo" => [],
            "newTodo" => $todo
        ]);
    }

    public function adding()
    {
        $this->setLayout('main2');
        return $this->render("Add");
    }
}
