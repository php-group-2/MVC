<?php

namespace App\core;

class Session
{
    public static function flash($name, $message, $expire = 5)
    {
        setcookie($name, $message, $expire, '/');
    }

    public static function start()
    {
        session_start();
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function close()
    {
        session_destroy();
    }
}
