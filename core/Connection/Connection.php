<?php

namespace App\core\Connection;

use PDO;

class Connection implements ConnectionInterface
{
  private static $instance = null;
  private $host = "localhost";
  private $name = "MVC";
  private $user = "root";
  private $pass = "4845647";

  private PDO $conn;

  private function __construct()
  {
    $this->conn = new PDO(
      "mysql:host={$this->host};dbname={$this->name}",
      $this->user,
      $this->pass,
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
