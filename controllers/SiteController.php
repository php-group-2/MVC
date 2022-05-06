<?php

namespace App\controllers;

use App\core\Request;
use App\core\View;
use App\model\Todo;

class SiteController
{
    public Todo $todo;

    public function __construct()
    {
        $this->todo = new Todo;
    }

    public function home(Request $request)
    {
        $id = $request->getBody()['id'];

        return (new View)->renderView("home", ["todo" => $this->todo->getTodo($id)]);
    }

    public function addTodo(Request $request)
    {
        $task = $request->getBody()['todo'];
        $this->todo->addTodo($task);

        return (new View)->renderView("home", ["todo" => $this->todo->getTodo()]);
    }

    public function adding()
    {
        return (new View)->renderView("Add");
    }

    public function toggleTodo(Request $request)
    {
        $data = $request->getBody();
        $id = $data["id"];
        $status = $data["status"];
        if ($status === "false") $status = 0;
        if ($status === "true") $status = 1;
        $this->todo->toggleTodo($id, $status);
    }
}
