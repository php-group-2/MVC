<?php

namespace App\middlewares;

use App\core\Auth as User;

class Auth
{
    private static array $message = [];

    public function check(): bool
    {
        if (!User::isLogin()) {
            self::$message['warningMessage'] = "You must be a user";
            return false;
        }

        return true;
    }
}
