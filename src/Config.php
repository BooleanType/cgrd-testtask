<?php

declare(strict_types=1);

namespace App;

readonly class Config
{
    public const string USERNAME = 'admin';
    public const string PASSWORD = 'test';
    
    public const array DB = [
        'host' => 'db',
        'dbname' => 'cgrd',
        'user' => 'root',
        'password' => 'secret',
        'charset' => 'utf8mb4',
    ];
}
