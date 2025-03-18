<?php

namespace App\classes;

class authService
{
    public static function verifyPassword(string $rawPassword , string $hashedPassword): bool
    {
        return password_verify($rawPassword, $hashedPassword);
    }
}
