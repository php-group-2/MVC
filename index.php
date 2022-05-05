<?php

include_once __DIR__ . "/vendor/autoload.php";

use App\core\Application;
use App\core\Router;

$app = new Application;

$app->router->get("/", function () {
    return "Hello World";
});
$app->router->get("/about", function () {
    return "About Us";
});
$app->router->get("/contact", function () {
    return "Contact Us";
});
$app->router->post("/contact", function () {
    return "Contact Us";
});

$app->run();
