<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;
use App\core\Response;
use App\core\View;
use App\models\Task;
use App\models\User;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->setLayout('main');
    }

    public function delete(Request $request, Response $response)
    {
        $data = $request->getBody();
        $id = $data['id'];
        $type = $data['type'];
        if ($type === "delete") {
            Task::do()->delete($id);
            $response->redirect('/');
        }
    }

    public function home(Request $request)
    {
        $result = Task::do()->all();
        return $this->render("home", ["tasks" => $result]);
    }

    public function add(Request $request, Response $response)
    {

        $data = $request->getBody();
        // var_dump($data);
        if ($request->isPost()) {
            $newData = [
                "title" => $data['title'],
                "description" => $data['desc'],
                "color" => $data['color'] ?? null,
                "deadline" => $data['dline'] ? $data['dline'] : null,
            ];

            $result = Task::do()->create($newData);
            if ($result) {
                $response->redirect("/");
            }

            return $this->render("Add", [
                'error' => "Error addding task",
            ]);
        }

        $this->setLayout('main2');

        return $this->render("Add");
    }
}
