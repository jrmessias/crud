<?php

namespace App\Core;

use Dotenv\Dotenv;
use PDO;

class Database
{
    private static ?PDO $conn = null;

    public static function getConnection(): PDO
    {
        $root = dirname(__DIR__, 2);
        if (file_exists($root . '/.env')) {
            $dotenv = Dotenv::createImmutable($root);
            $dotenv->load();
        }

        if (!self::$conn) {
            $dsn = sprintf(
                "%s:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                $_ENV['DB_DRIVER'] ?? 'mysql',
                $_ENV['DB_HOST'] ?? '127.0.0.1',
                $_ENV['DB_PORT'] ?? '3306',
                $_ENV['DB_NAME'] ?? 'crud_php'
            );
            self::$conn = new PDO($dsn, $_ENV['DB_USER'] ?? 'root', $_ENV['DB_PASS'] ?? '');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self::$conn;
    }
}
