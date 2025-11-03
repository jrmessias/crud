<?php

namespace App\Services;

use App\Core\Csrf;
use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function register(string $name, string $email, string $password): int
    {
        $hash = self::hashPassword($password);
        return $this->repo->create($name, strtolower(trim($email)), $hash);
    }

    public function attempt(string $email, string $password): bool
    {
        $row = $this->repo->findByEmail(strtolower(trim($email)));
        if (!$row || !password_verify($password, $row['password_hash'])) return false;

        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
        if (password_needs_rehash($row['password_hash'], $algo)) {
            $newHash = self::hashPassword($password);
            $this->repo->updatePasswordHash((int)$row['id'], $newHash);
            $row['password_hash'] = $newHash;
        }

        $this->login((int)$row['id'], $row['name'], $row['email']);
        return true;
    }

    public function login(int $id, string $name, string $email): void
    {
        Csrf::ensureSession();
        $_SESSION['auth'] = ['id' => $id, 'name' => $name, 'email' => $email];
    }

    public function logout(): void
    {
        Csrf::ensureSession();
        unset($_SESSION['auth']);
    }

    public static function user(): ?array
    {
        Csrf::ensureSession();
        return $_SESSION['auth'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        $row = $this->repo->find($userId);
        if (!$row || !password_verify($currentPassword, $row['password_hash'])) return false;

        $newHash = self::hashPassword($newPassword);
        return $this->repo->updatePasswordHash($userId, $newHash);
    }

    public static function hashPassword(string $password): string
    {
        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
        return password_hash($password, $algo);
    }
}
