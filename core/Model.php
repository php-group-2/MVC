<?php

namespace App\core;

abstract class Model
{
    protected $table; // which table this model should work on
    public MySqlDatabase $query;
    public MySqlDatabase $where = [];

    public function __construct()
    {
        $this->query = MySqlDatabase::do()->table($this->table);
    }

    public function all() // return all records
    {
        return $this->query->select()->fetchAll();
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
    }
    public function where($oprand1, $oprand2, $operation = '='): self
    {
        $this->where[] = $this->query->select()->where($oprand1, $oprand2, $operation);
        return $this;
    }
    public function get() // return all the filtered  records by where method
    {
        return $this->DB->fetchAll();
    }
    public function update(array $data)
    {
    }
}
