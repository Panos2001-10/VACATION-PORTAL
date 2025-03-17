<?php

namespace App;

class AuthService
{
    /**
     * Verify a raw password against the user's hashed password.
     *
     * @param User   $user        The user whose password we want to check.
     * @param string $rawPassword The plain text password from the login form.
     *
     * @return bool True if the password is correct, false otherwise.
     */
    public static function verifyPassword(User $user, string $rawPassword): bool
    {
        return password_verify($rawPassword, $user->getHashedPassword());
    }
}
