<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\core\Response;
use App\core\Validation;
use App\models\Task;
use App\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->setLayout('main2');
    }

    public function register(Request $request, Response $response)
    {
        $errors = [];
        if ($request->isPost()) {
            $data = $request->getBody();

            $errors = Validation::make()
                ->rules($this->registerRules())
                ->setData($data)
                ->validate();

            // dd($errors);
            if (empty($errors)) {
                // $email = $data['email'];
                // $password = $data['password'];
                // $name = $data['name'];
                // $phone = $data['phone'];
                // TODO INSERT
                // User::do()->insert()
                $response->redirect('/');
            }
            dd($errors);
        }
        return $this->render('register', ['errors' => $errors]);
    }

    public function login(Request $request, Response $response)
    {
        return $this->render('login');
    }


    public function registerRules()
    {
        return [
            'email' => ['required', 'email', 'unique'],
            'password' => ['required', 'min:4'],
            'name' => "alphabet|min:5",
            'phone' => "numeric|min:5|max:11|phone",
        ];
    }

    public function loginRules()
    {
        return [
            'email' => ['required', 'email', 'unique'],
            'password' => ['required', ['min' => 4]],
        ];
    }
}
