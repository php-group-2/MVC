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
        Task::do()->delete($id);
        $response->redirect('/');
    }

    public function put(Request $request, Response $response)
    {
        $data = $request->getBody();
        // dd($data);
        $id = $data['id'];
        $updatedData = [
            "title" => $data['title'],
            "description" => $data['desc'],
            "color" => $data['color'] ?? null,
            "deadline" => $data['dline'] ? $data['dline'] : null,
        ];

        Task::do()->update($updatedData)->where('id', $id)->exec();
        $response->redirect('/');
    }

    public function home()
    {
        $result = Task::do()->all();
        return $this->render("home", ["tasks" => $result]);
    }

    public function toggleStatus(Request $request)
    {
        $id = $request->getBody()['id'];
        $data = Task::do()->find($id);
        $status = 0;
        if ($data) $status = $data->status;
        $status = $status ? 0 : 1;
        return Task::do()->update(['status' => $status])->where('id', $id)->exec();
    }

    public function add(Request $request, Response $response)
    {

        $data = $request->getBody();
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
