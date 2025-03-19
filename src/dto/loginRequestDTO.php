<?php

namespace App\dto;

use App\classes\valueObjects\email;
use App\classes\valueObjects\password;

class loginRequestDTO
{
    private email $email;
    private password $password;

    /**
     * Constructor to initialize email and password fields.
     */
    public function __construct(string $email, string $password)
    {
        $this->email = new email($email);
        $this->password = new password($password);
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }
}
