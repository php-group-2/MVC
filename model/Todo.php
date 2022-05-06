<?php

namespace App\model;

use PDO;

class Todo
{
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public PDO $conn ;
    public function __construct()
    {
        $this->conn = new PDO("mysql:host={$this->servername};dbname=todo", $this->username, $this->password);
    }
    public  function getAllTodo()
    {
       $query = "select * from todos " ;
       $stat = $this->conn->query($query) ;
       return $stat->fetchAll(PDO::FETCH_ASSOC) ;
    }
    public  function getOneTodo($id)
    {
       $query = "select * from todos WHERE id = ?" ;
       $->prepare(, $id);
        $stmt->execute();
       $stat = $this->conn->query($query) ;
       return $stat->fetchAll(PDO::FETCH_ASSOC) ;
    }
    
    
    public  function addTodo($task)
    {
       
    }
}
