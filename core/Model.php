<?php

namespace App\core;

abstract class Model
{
    protected $table; // which table this model should work on
    private DatabaseInterface $db;
    private DatabaseInterface $query;

    public function __construct()
    {
        $this->db = MySqlDatabase::do();
        $this->query = $this->db->table($this->getTable());
    }

    abstract public function getTable(): string;

    public static function do()
    {
        return new static;
    }

    public function all() // return all records
    {
        return $this->db->table($this->getTable())->select()->fetchAll();
    }
    public function find(string $value, string $col = 'id') // return the record
    {
        return $this->query->select()->where($col, $value)->fetch();
    }
    public function create(array $data) // make a new recorde 
    {
        return $this->query->insert($data)->exec();
    }
    public function delete($id)
    {
        return $this->query->delete()->where('id', $id)->exec();
    }
    public function where($va1, $val2, $operation = '=', $condition = "AND"): self
    {
        $this->query->where($va1, $val2, $operation, $operation);
        return $this;
    }
    public function get() // return all the filtered  records by where method
    {
        return $this->query->fetchAll();
    }
    public function update(array $data)
    {
        $this->query->update($data);
        return $this;
    }
    public function exec()
    {
        return $this->query->exec();
    }
}
