<?php

namespace App\classes\valueObjects;

use App\interfaces\valueObjectInterface;
use InvalidArgumentException;

class email implements valueObjectInterface{
    private string $email;

    public function __construct(string $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Please enter a valid email address.");
        }
        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }
}