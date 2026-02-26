<?php

namespace App\Controllers;

use App\Auth\JWTAuth;
use PDO;

class AuthController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function login($email, $password) {
        if (!preg_match('/^[\w\.]+@[centrumnadania]+\.sk$/', $email)) {
            return ['error' => 'Invalid email domain'];
        }

        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $token = JWTAuth::encode(['id' => $user['id'], 'role' => $user['role']]);
            return ['token' => $token];
        }

        return ['error' => 'Invalid credentials'];
    }
}
