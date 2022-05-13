<?php

namespace App\models;

use App\core\Model;

final class Task extends Model
{
    public function getTable(): string
    {
        return "tasks";
    }
}
