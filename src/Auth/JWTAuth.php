<?php

namespace App\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth {
    private static $secretKey = 'your_secret_key';
    private static $algorithm = 'HS256';

    public static function encode(array $payload): string {
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function decode(string $jwt): object {
        return JWT::decode($jwt, new Key(self::$secretKey, self::$algorithm));
    }
}
