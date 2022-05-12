<?php

include_once __DIR__ . "/../vendor/autoload.php";

use App\controllers\SiteController;
use App\core\Application;

$app = new Application(dirname(__DIR__));

$app->get("/", [SiteController::class, "home"]);
$app->post("/", [SiteController::class, "toggleTodo"]);
$app->get("/todo", [SiteController::class, "adding"]);
$app->post("/todo", [SiteController::class, "addTodo"]);


$app->run();
