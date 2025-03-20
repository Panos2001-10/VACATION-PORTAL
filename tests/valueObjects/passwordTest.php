<?php

namespace valueObjects;

use App\classes\valueObjects\Password;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class passwordTest extends TestCase
{
    public function testValidPassword()
    {
        $password = new Password("secure123");
        $this->assertEquals("secure123", $password->getValue());
    }

    public function testShortPasswordThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Password("123");
    }

    public function testEmptyPasswordThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Password("");
    }
}
