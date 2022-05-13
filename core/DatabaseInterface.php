<?php

namespace App\core;

use App\core\Connection\ConnectionInterface;

interface DatabaseInterface
{
    public function __construct(ConnectionInterface $connection);
    public static function do(): self;
    public function table(string $table): self;
    public function select(array $cols = ['*']): self;
    public function insert(array $fields): self;
    public function update(array $fields): self;
    public function delete(): self;
    public function where(string $val1, string $val2, string $operation = '=', $condition = "AND"): self;

    public function fetch();
    public function fetchAll();
    public function exec(): bool;
}
