<?php

include_once __DIR__ . "/../vendor/autoload.php";

use App\controllers\SiteController;
use App\core\Application;
use App\core\Request;

$app = new Application(dirname(__DIR__));

$app->get("/", [SiteController::class, "home"]);
$app->get("/todo", [SiteController::class, "adding"]);
$app->post("/todo", [SiteController::class, "addTodo"]);
$app->post("/", [SiteController::class, "toggleTodo"]);

// $app->get("/about", function (Request $request) {
//     $data = $request->getBody();
//     var_dump($data);
//     return "About Us!";
// });

$app->run();
