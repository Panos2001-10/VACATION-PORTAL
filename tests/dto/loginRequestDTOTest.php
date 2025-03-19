<?php

namespace dto;

use PHPUnit\Framework\TestCase;
use App\dto\LoginRequestDTO;
use InvalidArgumentException;

class loginRequestDTOTest extends TestCase
{
    public function testValidLoginRequest()
    {
        $loginRequest = new LoginRequestDTO("user@example.com", "secure123");
        $this->assertEquals("user@example.com", $loginRequest->getEmail()->getValue());
        $this->assertEquals("secure123", $loginRequest->getPassword()->getValue());
    }

    public function testInvalidEmailThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new LoginRequestDTO("invalid-email", "secure123");
    }

    public function testShortPasswordThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new LoginRequestDTO("user@example.com", "123");
    }
}
