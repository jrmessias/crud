<?php

namespace App\Repositories;

use App\Core\Database;

class UserRepository
{

    public function authenticate(string $email, string $password): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1");
        $stmt->execute([$email, $password]);
//        echo "Debugging PDO Statement:\n";
//        $stmt->debugDumpParams();
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $st = Database::getConnection()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public function create(string $name, string $email, string $password_hash): int
    {
        $st = Database::getConnection()->prepare("INSERT INTO users(name,email,password_hash) VALUES(?,?,?)");
        $st->execute([$name, $email, $password_hash]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $st = Database::getConnection()->prepare("SELECT * FROM users WHERE id=?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function updatePasswordHash(int $id, string $newHash): bool
    {
        $st = Database::getConnection()
            ->prepare("UPDATE users SET password_hash=? WHERE id=?");
        return $st->execute([$newHash, $id]);
    }
}
