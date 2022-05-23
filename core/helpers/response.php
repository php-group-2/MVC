<?php

use App\core\Application;

function response(mixed $data, $statusCode = 200)
{
    Application::$app->response->setStatusCode($statusCode);

    dd($data);
    // API
    if (is_array($data)) {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_encode($data);
    }

    return $data;
}
