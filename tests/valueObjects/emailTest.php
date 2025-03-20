<?php

namespace valueObjects;

use App\classes\valueObjects\email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class emailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = new Email("user@example.com");
        $this->assertEquals("user@example.com", $email->getValue());
    }

    public function testInvalidEmailThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Email("invalid-email");
    }

    public function testEmptyEmailThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Email("");
    }
}
