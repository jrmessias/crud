<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserService
{
    public function validate(array $data): array
    {
        $errors = [];
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($email === '') $errors['email'] = 'E-mail é obrigatório';
        if ($password === '') $errors['password'] = 'Senha é obrigatória';

        return $errors;
    }
}
