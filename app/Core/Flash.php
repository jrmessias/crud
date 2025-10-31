<?php

namespace App\Core;
class Flash
{
    public static function push(string $type, string $message): void
    {
        Csrf::ensureSession();
        $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
    }

    public static function pullAll(): array
    {
        Csrf::ensureSession();
        $all = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $all;
    }
}
