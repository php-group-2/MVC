<?php

include_once __DIR__ . "/vendor/autoload.php";

use App\core\MySqlDatabase;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

MySqlDatabase::do()->applyMigrations();
