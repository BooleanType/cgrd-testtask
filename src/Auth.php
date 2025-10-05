<?php

declare(strict_types=1);

namespace App;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        if ($username === Config::USERNAME && $password === Config::PASSWORD) {
            $_SESSION['user'] = $username;
            return true;
        }
        
        return false;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }
}
