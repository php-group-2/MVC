<?php

namespace App\core;

class Request {
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}