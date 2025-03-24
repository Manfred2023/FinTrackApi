<?php

namespace App\Middlewares;

use Exception;
use Helper\Constant;
use Helper\Jwt;
use Helper\Reply;

class AuthMiddleware
{
    public static function handle()
    {
        // Vérification de l'existence du header Authorization
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            Reply::_error("No HTTP_AUTHORIZATION header found", code: 401);
            error_log("No HTTP_AUTHORIZATION header found");
            return false;
        }

        // Extraction du token Bearer du header Authorization
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

        // Vérification si le header commence par "Bearer "
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Reply::_error("Invalid Bearer token format", code: 401);
            error_log("Invalid Bearer token format");
            return false;
        }

        $token = $matches[1];
        return self::validateToken($token);
    }

    public static function  validateToken(string $token): bool
    {
        try {
            $jwt = new Jwt(Constant::JWT_KEY, );

            $decoded = $jwt->decode($token);

            if ($decoded === null) {
                Reply::_error("Token validation failed: invalid token", code: 401);
                error_log("Token validation failed: invalid token");
                return false;
            }

            if ($decoded['app'] !== 'FinTrack') {
                Reply::_error("Token validation failed: invalid app", code: 401);
                error_log("Token validation failed: invalid token");
                return false;
            }
            if ($decoded['version'] !== '1.0.0') {
                Reply::_error("Token validation failed: invalid app", code: 401);
                error_log("Token validation failed: invalid token");
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Token validation error: " . $e->getMessage());
            return false;
        }
    }
}

