<?php

namespace App\model;

use PDO;

class Todo
{
    public $servername = "localhost";
    public $username = "root";
    public $password = "4845647";
    public PDO $conn;
    public function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->servername};dbname=todo", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    public  function getTodo($id = null)
    {
        if (isset($id)) {
            $query = "SELECT * FROM todos WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([(int) $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $query = "SELECT * FROM todos";
        $stat = $this->conn->query($query);
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTodo($task)
    {
        $query = "INSERT INTO todos (task) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$task]);
    }

    public function toggleTodo($id, $status)
    {
        $query = "UPDATE todos SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([":status" => $status, ":id" => $id]);
    }
}
