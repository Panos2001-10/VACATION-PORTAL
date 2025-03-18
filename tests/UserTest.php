<?php
use PHPUnit\Framework\TestCase;
use App\user;

class UserTest extends TestCase
{
    public function testVerifyPassword()
    {
        $rawPassword = 'secret';
        $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
        $user = new user(1, 2, 'Test user', 'test@example.com', $hashedPassword, 'employee');

        $this->assertTrue($user->verifyPassword('secret'));

        $this->assertFalse($user->verifyPassword('wrongpassword'));
    }
}
