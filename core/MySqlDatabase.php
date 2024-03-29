<?php

namespace App\core;

use App\core\Connection\Connection;
use App\core\Connection\ConnectionInterface;
use PDO;

class MySqlDatabase implements DatabaseInterface
{
    public PDO $db;
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

    public function delete(): DatabaseInterface
    {
        $this->query = "DELETE FROM " . $this->table;
        return $this;
    }

    public function where(string $val1, string $val2, string $operation = '=', $condition = "AND"): DatabaseInterface
    {
        if (str_contains($this->query, "WHERE")) {
            $this->query .= " $condition ";
        } else {
            $this->query .= " WHERE ";
        }

        // NOTE: WE CAN ADD OR WHERE 
        // NOTE: WE CAN ADD AND WHERE
        $this->query .= "$val1 $operation '$val2'";
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

    public function applyMigrations()
    {
        $this->createMigrationsTable();

        $applied = $this->getAppliedMigrations();

        $new = [];

        $direcotires = scandir(__DIR__ . "/../migrations/");
        $direcotires = array_diff($direcotires, ['.', '..']);

        foreach ($direcotires as $dir) {
            require_once __DIR__ . "/../migrations/$dir";

            // Change name from mxxx_name_class to NameClass
            $dir = str_replace(".php", "", $dir);
            $dir = array_map(fn ($v) => ucwords($v), explode('_', $dir));
            unset($dir[0]);
            $className = implode("", $dir);

            // Check if this migration is already applied
            if (!in_array($className, $applied)) {
                $this->log("$className migration applied");
                $className::up();
                $new[] = $className;
            }
        }

        if (!empty($new)) {
            $this->saveMigrations($new);
        } else {
            echo "All migrations already applied";
        }
    }

    public function createMigrationsTable()
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }


    public function getAppliedMigrations()
    {
        $statement = $this->db->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn ($m) => "('$m')", $newMigrations));
        $statement = $this->db->prepare("INSERT INTO migrations (migration) VALUES 
            $str -- ('CreateUserTable','CreateTasksTable')
        ");
        $statement->execute();
    }

    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}
