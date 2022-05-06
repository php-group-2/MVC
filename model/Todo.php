<?php

namespace App\model;

class Todo
{
    public static function getTodo()
    {
        if (!file_exists('todo.json'))
            file_put_contents('todo.json', "");

        $file = file_get_contents('todo.json');
        $todo = json_decode($file, true);

        return $todo;
    }

    public static function addTodo($task)
    {
        $todo = self::getTodo();
        $todo[] = [
            "task" => $task,
            "done" => false,
        ];
        $json = json_encode($todo, JSON_PRETTY_PRINT);
        file_put_contents('todo.json', $json);
    }
}
