<?php

use App\core\Application;

include_once __DIR__ . "/../vendor/autoload.php";

$app = new Application();

$app->router->get('/', function () {
    return "Hello World";
});

$app->run();
