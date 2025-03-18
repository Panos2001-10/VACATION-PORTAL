<?php

namespace App\dto;

class LoginRequestDTO
{
    private string $email;
    private string $password;

    /**
     * Constructor to initialize email and password fields.
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
//        echo $this->email;
//        echo $this->password;
//        die();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
