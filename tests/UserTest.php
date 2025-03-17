<?php
use PHPUnit\Framework\TestCase;
use App\User;

class UserTest extends TestCase
{
    public function testVerifyPassword()
    {
        $rawPassword = 'secret';
        $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
        $user = new User(1, 2, 'Test User', 'test@example.com', $hashedPassword, 'employee');

        $this->assertTrue($user->verifyPassword('secret'));

        $this->assertFalse($user->verifyPassword('wrongpassword'));
    }
}
