<?php
namespace App\Repositories;

use App\Core\Database;
use App\Models\Product;
use PDO;

class UserRepository {

    public function authenticate(string $email, string $password): ?array {

        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1");
        $stmt->execute([$email, $password]);

//        echo "Debugging PDO Statement:\n";
//        $stmt->debugDumpParams();

        $row = $stmt->fetch();
        return $row ?: null;
    }

}
