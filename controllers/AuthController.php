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

            if (empty($errors)) {
                try {
                    User::do()->create($this->getRegisterData($data));
                    $response->redirect('/');
                } catch (\Throwable $th) {
                    $errors['email'][] = "its not unique";
                    return $this->render('register', ['errors' => $errors]);
                }
            }
            dd($errors);
        }
        return $this->render('register', ['errors' => $errors]);
    }

    public function getRegisterData($data)
    {
        // $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $password = $this->hashPassword($data['password']);
        $data['password'] = $password;
        return $data;
    }

    public function hashPassword($pass)
    {
        return hash('sha256', $pass);
    }

    public function login(Request $request, Response $response)
    {
        $errors = [];
        if ($request->isPost()) {
            $data = $request->getBody();

            $errors = Validation::make()
                ->rules($this->loginRules())
                ->setData($data)
                ->validate();

            if (empty($errors)) {

                // $user = User::do()->find($data['email'], 'email');
                // if (!password_verify($data['password'], $user->password)) {
                //     $errors['password'][] = 'Password in incorect!';
                // }

                $user = User::do()->select(['name', 'phone', 'email', 'id'])
                    ->where('email', $data['email'])
                    ->where('password', $this->hashPassword($data['password']))
                    ->get();
                if ($user === false) {
                    $errors['password'][] = 'Email or Password is incorect';
                    return $this->render('login', ['errors' => $errors]);
                }
                setcookie('user_id', $user->id, 0, '/');
                $response->redirect('/');
            }
        }
        return $this->render('login', ['errors' => $errors]);
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
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ];
    }
}
