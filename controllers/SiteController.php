<?php

namespace App\controllers;

use App\core\Request;
use App\core\View;
use App\model\Todo;

class SiteController
{
    private array $todo = [];

    public function __construct()
    {
        $this->todo = Todo::getTodo() ?? [];
    }

    public function home()
    {
        return (new View)->renderView("home", ["todo" => $this->todo]);
    }

    public function addTodo(Request $request)
    {
        $task = $request->getBody()['todo'];
        Todo::addTodo($task);
        $this->todo = Todo::getTodo();
        return (new View)->renderView("home", ["todo" => $this->todo]);
    }

    public function contact()
    {
        $todo = Todo::getTodo();
        return (new View)->renderView("contact");
    }

    public function getData()
    {
    }
}
