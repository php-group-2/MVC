<?php

namespace App\controllers;

use App\core\Request;
use App\core\View;

class SiteController
{

    public function home(Request $request)
    {
        $id = $request->getBody()['id'];

        return (new View)->renderView("home", ["todo" => ""]);
    }

    public function addTodo(Request $request)
    {
        $task = $request->getBody()['todo'];

        return (new View)->renderView("home", ["todo" => ""]);
    }

    public function adding()
    {
        return (new View)->renderView("Add");
    }
}
