<?php

namespace App\valueObjects;

use App\MessageHandler;

class email {
    private string $email;

    public function __construct(string $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException();
        }
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }
}