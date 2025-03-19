<?php

namespace App\classes\valueObjects;

use App\interfaces\ValueObjectInterface;
use InvalidArgumentException;

class password implements ValueObjectInterface
{
    private string $password;

    public function __construct(string $password)
    {
        // Basic validation: Password must not be empty
        if (empty($password)) {
            throw new InvalidArgumentException("Password cannot be empty.");
        }

        // Basic validation: Minimum length for security
        if (strlen($password) < 6) {
            throw new InvalidArgumentException("Password must be at least 6 characters long.");
        }

        //trong password rules for registration
        /*
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException("Password must include at least one uppercase letter.");
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException("Password must include at least one lowercase letter.");
        }

        if (!preg_match('/\d/', $password)) {
            throw new InvalidArgumentException("Password must include at least one number.");
        }

        if (!preg_match('/[\W]/', $password)) {
            throw new InvalidArgumentException("Password must include at least one special character.");
        }
        */

        $this->password = $password;
    }

    public function getValue(): string
    {
        return $this->password;
    }
}
