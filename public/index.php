<?php

include_once __DIR__ . "/../vendor/autoload.php";

use App\controllers\AuthController;
use App\controllers\SiteController;
use App\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$app = new Application(dirname(__DIR__));

$app->get("/", [SiteController::class, "home"]);

// sign in and up
$app->get("/register", [AuthController::class, "register"]);
$app->post("/register", [AuthController::class, "register"]);
$app->get("/login", [AuthController::class, "login"]);
$app->post("/login", [AuthController::class, "login"]);

$app->get("/todo", [SiteController::class, "add"]);
$app->post("/todo", [SiteController::class, "add"]);
$app->post("/todo/{id}", [SiteController::class, "add"]);

$app->delete('/delete', [SiteController::class, 'delete']);
$app->put('/update', [SiteController::class, 'update']);
$app->put('/toggle', [SiteController::class, 'toggleStatus']);

$app->run();
