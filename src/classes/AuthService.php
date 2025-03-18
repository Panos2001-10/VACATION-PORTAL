<?php

namespace App;

class AuthService
{
    public static function verifyPassword(string $rawPassword , string $hashedPassword): bool
    {
        return password_verify($rawPassword, $hashedPassword);
    }
}
