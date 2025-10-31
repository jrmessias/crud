<?php

namespace App\Core;

class Csrf
{
    public static function validate(?string $token): bool
    {
        self::ensureSession();
        return is_string($token) && hash_equals($_SESSION['_csrf'] ?? '', $token);
    }

    public static function ensureSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    public static function input(): string
    {
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function token(): string
    {
        self::ensureSession();
        if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['_csrf'];
    }
}
