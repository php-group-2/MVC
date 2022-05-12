<?php

namespace App\controllers;

use App\core\Request;
use App\core\View;

class SiteController
{

    public function home(Request $request)
    {
        return (new View)->renderView("home", ["todo" => []]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->get('todo');
        return (new View)->renderView("Add", [
            "todo" => [],
            "newTodo" => $todo
        ]);
    }

    public function adding()
    {
        return (new View)->renderView("Add");
    }
}
