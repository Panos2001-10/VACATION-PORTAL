<?php

namespace App\dto;

use App\classes\valueObjects\email;

class loginRequestDTO
{
    private email $email;
    private string $password;

    /**
     * Constructor to initialize email and password fields.
     */
    public function __construct(string $email, string $password)
    {
        $this->email = new email($email);
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email->getEmail();
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
