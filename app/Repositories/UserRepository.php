<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\User;

class UserRepository
{
    public function countAll(): int
    {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = Database::getConnection()->prepare("SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(User $u): int
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$u->name, $u->email, $u->password_hash]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(User $u): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE users SET name = ?, email = ?, password_hash = ? WHERE id = ?");
        return $stmt->execute([$u->name, $u->email, $u->password_hash, $u->id]);
    }

    public function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByEmail(string $email): ?array
    {
        $st = Database::getConnection()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public function updatePasswordHash(int $id, string $newHash): bool
    {
        $st = Database::getConnection()
            ->prepare("UPDATE users SET password_hash=? WHERE id=?");
        return $st->execute([$newHash, $id]);
    }

    public function findByEmailNotId(string $email, mixed $id)
    {
        $st = Database::getConnection()->prepare("SELECT * FROM users WHERE email=? AND id!=? LIMIT 1");
        $st->execute([$email, $id]);
        return $st->fetch() ?: null;
    }
}
