<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function validate(array $data): array
    {
        $errors = [];
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');

        if ($name === '') $errors['name'] = 'Nome é obrigatório';
        if ($email === '') $errors['email'] = 'E-mail é obrigatório';
        if ($password === '') $errors['password'] = 'Senha é obrigatória';

        return $errors;
    }

    public function make(array $data,): User {
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password_hash = trim($data['password'] ?? '');
        $id = isset($data['id']) ? (int)$data['id'] : null;
        return new User($id, $name, $email, $password_hash);
    }
}
