<?php

declare(strict_types=1);

namespace App;

class Flash
{
    private const string KEY = 'flash';

    public static function set(string $message, string $type = 'error'): void
    {
        $_SESSION[self::KEY] = [
            'message' => $message,
            'type'    => $type,
        ];
    }

    public static function get(): ?array
    {
        if (!isset($_SESSION[self::KEY])) {
            return null;
        }

        $flash = $_SESSION[self::KEY];
        unset($_SESSION[self::KEY]);
        
        return $flash;
    }
}
