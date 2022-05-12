<?php

namespace App\core;

use App\core\Connection\Connection;
use App\core\Connection\ConnectionInterface;
use PDO;

class MySqlDatabase implements DatabaseInterface
{
    private PDO $db;
    private string $table;
    private string $query;
    private array $fields = [];
    private array $where = [];

    public function __construct(ConnectionInterface $connection)
    {
        $this->db = $connection->getConnection();
    }

    public static function do(): self
    {
        return new self(Connection::getInstance());
    }

    // Add table name in the first place
    public function table(string $table): DatabaseInterface
    {
        $this->table = $table;
        return $this;
    }

    // Create table then exec
    // public function create()
    // {
    //     $this->query = "CREATE TABLE {$this->table}";
    //     return $this;
    // }

    // Drop table then exec
    public function drop()
    {
        $this->query = "DROP TABLE {$this->table}";
        return $this;
    }

    // SELECT array $cols from table then fetch or fetchAll
    public function select(array $cols = ['*']): DatabaseInterface
    {
        $this->query =
            "SELECT " . implode(",", $cols) .
            " FROM " . $this->table;
        return $this;
    }

    // SELECT array $cols from table then fetch or fetchAll
    public function insert(array $fields): DatabaseInterface
    {
        $this->fields = $fields;

        $params = array_map(fn ($v) => ":$v", array_keys($fields));

        $this->query =
            "INSERT INTO " . $this->table .
            "(" . implode(",", array_keys($fields)) . ") " .
            "VALUES (" . implode(",", $params) . ")";

        return $this;
    }

    public function update(array $fields): DatabaseInterface
    {
        $this->fields = $fields;

        $arr = array_map(
            fn ($key) => "$key = :$key",
            array_keys($fields),
        );

        $this->query = "UPDATE " . $this->table . " SET " . implode(",", $arr);

        return $this;
    }

    public function where(string $val1, string $val2, string $operation = '='): DatabaseInterface
    {
        $this->where[] = [
            $val1, $val2, $operation
        ];

        // NOTE: WE CAN ADD OR WHERE 
        // NOTE: WE CAN ADD AND WHERE
        $this->query .= " WHERE $val1 $operation '$val2'";
        return $this;
    }

    public function AndWhere(string $val1, string $val2, string $operation = '='): DatabaseInterface
    {
        $this->where[] = [
            $val1, $val2, $operation
        ];

        // NOTE: WE CAN ADD OR WHERE 
        // NOTE: WE CAN ADD AND WHERE
        $this->query .= " AND $val1 $operation '$val2'";
        return $this;
    }
    public function OrWhere(string $val1, string $val2, string $operation = '='): DatabaseInterface
    {
        $this->where[] = [
            $val1, $val2, $operation
        ];

        // NOTE: WE CAN ADD OR WHERE 
        // NOTE: WE CAN ADD AND WHERE
        $this->query .= " OR $val1 $operation '$val2'";
        return $this;
    }

    private function prepare($query)
    {
        $statement = $this->db->prepare($query);
        foreach ($this->fields as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        return $statement;
    }

    public function fetch()
    {
        $statement = $this->prepare($this->query);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll()
    {
        $statement = $this->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function exec(): bool
    {
        $statement = $this->prepare($this->query);
        return $statement->execute();
    }
}
