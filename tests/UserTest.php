<?php
// tests/UserTest.php

use PHPUnit\Framework\TestCase;
require_once './src/User.php';

class UserTest extends TestCase {
    
    public function testUserSignUp() {
        // Create a new User instance
        $user = new User('John', 'Doe', 'john.doe@example.com', 'password123');

        // Check if the user's full name is correct
        $this->assertEquals('John Doe', $user->getFullName());

        // Check if the user's email is correct
        $this->assertEquals('john.doe@example.com', $user->getEmail());

        // Verify that the password is correctly hashed and can be verified
        $this->assertTrue($user->verifyPassword('password123'));
    }

    public function testPasswordVerificationFailsWithWrongPassword() {
        // Create a new User instance
        $user = new User('Jane', 'Smith', 'jane.smith@example.com', 'securepass');

        // Check that the password verification fails with the wrong password
        $this->assertFalse($user->verifyPassword('wrongpassword'));
    }
}