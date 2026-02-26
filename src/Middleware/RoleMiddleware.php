<?php

namespace App\Middleware;

use App\Auth\JWTAuth;

class RoleMiddleware {
    public static function checkRole($requiredRole, $jwt) {
        try {
            $decoded = JWTAuth::decode($jwt);
            if ($decoded->role !== $requiredRole) {
                return ['error' => 'Unauthorized access'];
            }
            return null; // No error
        } catch (Exception $e) {
            return ['error' => 'Invalid token'];
        }
    }
}
