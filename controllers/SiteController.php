<?php

namespace App\controllers;

use App\core\Request;
use App\core\View;
use App\model\Todo;

class SiteController
{
    public Todo $todo ;

    public function __construct()
    {
        $this->todo = new Todo ;
        
    }

    public function home()
    {
        return (new View)->renderView("home", ["todo" => $this->todo->getTodo()]);
    }

    public function addTodo(Request $request)
    {
        $task = $request->getBody()['todo'];
        // Todo::addTodo($task);
        
        return (new View)->renderView("home", ["todo" => $this->todo->getTodo()]);
    }

    public function adding()
    {
    
        return (new View)->renderView("Add");
    }

}
