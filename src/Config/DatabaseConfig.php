<?php

namespace Src\Config;

use PDO;

class DatabaseConfig
{
    public static function getPdoConnection(): PDO
    {
        return new PDO(
            sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $_ENV['DB_HOST'], $_ENV['DB_DATABASE']),
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
