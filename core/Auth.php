<?php

namespace App\core;

class Auth
{
    public const ID = 'user_id';

    public static function getUserId()
    {
        return Session::get(self::ID);
    }

    public static function isLogin()
    {
        return !is_null(Session::get(self::ID));
    }

    public static function logout()
    {
        Session::unset(self::ID);
    }
}
