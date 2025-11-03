<?php
namespace App\Models;

class User {
    public ?int $id;
    public string $name;
    public string $email;
    public ?string $password_hash;
    public string $created_at;

    public function __construct(?int $id, string $name, string $email, ?string $password_hash = null, string $created_at = '') {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->created_at = $created_at;
    }
}
