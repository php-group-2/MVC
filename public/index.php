<?php

include_once __DIR__ . "/../vendor/autoload.php";

use App\controllers\SiteController;
use App\core\Application;

$app = new Application(dirname(__DIR__));

$app->get("/", [SiteController::class, "home"]);
$app->get("/todo", [SiteController::class, "add"]);
$app->post("/todo", [SiteController::class, "add"]);

$app->run();
