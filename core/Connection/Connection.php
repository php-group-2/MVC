<?php

namespace App\core\Connection;

use App\core\Application;
use PDO;

class Connection implements ConnectionInterface
{
  private static $instance = null;
  private PDO $conn;

  private function __construct()
  {
    $host = 'localhost';
    $name = $_ENV['DB_DATABASE'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $this->conn = new PDO(
      "mysql:host={$host};dbname={$name}",
      $user,
      $pass,
      [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ]
    );
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new Connection;
    }

    return self::$instance;
  }

  public function getConnection(): PDO
  {
    return $this->conn;
  }
}
