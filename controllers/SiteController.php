<?php

namespace App\controllers;

use App\core\Auth as CoreAuth;
use App\core\Controller;
use App\core\Request;
use App\core\Response;
use App\middlewares\Auth;
use App\models\Task;

class SiteController extends Controller
{
    public $middleware = null;

    public function __construct()
    {
        $this->setLayout('main');
        $this->middleware = new Auth;
    }

    public function delete(Request $request, Response $response)
    {
        $data = $request->getBody();
        $id = $data['id'];
        Task::do()->delete($id);
        $response->redirect('/');
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->getBody();
        $id = $data['id'];
        $updatedData = [
            "title" => $data['title'],
            "description" => $data['desc'],
            "color" => $data['color'] ?? null,
            "deadline" => $data['dline'] ? $data['dline'] : null,
            "user_id" => CoreAuth::getUserId() ?? null,
        ];

        Task::do()->update($updatedData)->where('id', $id)->exec();
        $response->redirect('/');
    }

    public function home()
    {
        $result = Task::do()->findAll(CoreAuth::getUserId(), 'user_id');
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
                "user_id" => CoreAuth::getUserId() ?? null,
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
