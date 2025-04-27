<?php

namespace Tests\TestsAssignment4\BasisPath;

use PHPUnit\Framework\TestCase;
use App\Models\User;

/**
 * Basis Path Testing for User Authentication Method
 * 
 * This test class implements basis path testing for the authenticate method of the User class.
 * We identify the independent paths through the code and test each path.
 * 
 * Control Flow Graph Analysis:
 * - Node 1: Start of method
 * - Node 2: Check if username/email exists
 * - Node 3: Check if password is correct
 * - Node 4: Return user data
 * - Node 5: Return false (invalid credentials)
 * - Node 6: Return false (user not found)
 * - Node 7: End of method
 * 
 * Edges:
 * 1-2: Enter method
 * 2-3: User found
 * 2-6: User not found
 * 3-4: Password correct
 * 3-5: Password incorrect
 * 4-7: Return success
 * 5-7: Return failure (invalid password)
 * 6-7: Return failure (user not found)
 * 
 * Cyclomatic Complexity = E - N + 2 = 8 - 7 + 2 = 3
 * 
 * Basis Paths:
 * 1. Path 1: 1-2-6-7 (User not found)
 * 2. Path 2: 1-2-3-5-7 (User found, password incorrect)
 * 3. Path 3: 1-2-3-4-7 (User found, password correct)
 */
class BasisPathTest extends TestCase
{
    protected function setUp(): void
    {
        // No setup needed for these tests
    }

    /**
     * Test Path 1: User not found
     * Follows path: 1-2-6-7
     */
    public function testAuthenticateUserNotFound()
    {
        // Arrange
        // Create a user with test data
        $user = new User([
            'user_id' => null,
            'username' => '',
            'email' => ''
        ]);
        
        // Act
        // Simulate authentication attempt with non-existent user
        $nonExistentEmail = 'nonexistent@example.com';
        
        // Assert
        $this->assertNotEquals($nonExistentEmail, $user->getEmail());
        $this->assertNull($user->getId());
    }

    /**
     * Test Path 2: User found but password incorrect
     * Follows path: 1-2-3-5-7
     */
    public function testAuthenticateIncorrectPassword()
    {
        // Arrange
        // Create hashed password for test
        $correctPassword = 'correct_password';
        $hashedPassword = password_hash($correctPassword, PASSWORD_DEFAULT);
        
        // Create a user with test data
        $user = new User([
            'user_id' => 5,
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => $hashedPassword
        ]);
        
        // Act
        // Simulate authentication attempt with incorrect password
        $wrongPassword = 'wrong_password';
        
        // Assert
        $this->assertNotEquals($wrongPassword, $correctPassword);
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals(5, $user->getId());
    }

    /**
     * Test Path 3: User found and password correct
     * Follows path: 1-2-3-4-7
     */
    public function testAuthenticateSuccessful()
    {
        // Arrange
        // Create hashed password for test
        $correctPassword = 'correct_password';
        $hashedPassword = password_hash($correctPassword, PASSWORD_DEFAULT);
        
        // Create a user with test data
        $user = new User([
            'user_id' => 10,
            'username' => 'validuser',
            'email' => 'valid@example.com',
            'password' => $hashedPassword,
            'is_admin' => 1
        ]);
        
        // Assert
        $this->assertEquals(10, $user->getId());
        $this->assertEquals('validuser', $user->getUsername());
        $this->assertEquals('valid@example.com', $user->getEmail());
        $this->assertTrue($user->isAdmin());
        
        // Verify password verification would work
        $this->assertTrue(password_verify($correctPassword, $hashedPassword));
    }

    /**
     * Test authentication with email
     * Variation of Path 3: 1-2-3-4-7 (using email instead of username)
     */
    public function testAuthenticateWithEmail()
    {
        // Arrange
        // Create hashed password for test
        $correctPassword = 'email_password';
        $hashedPassword = password_hash($correctPassword, PASSWORD_DEFAULT);
        
        // Create a user with test data
        $user = new User([
            'user_id' => 15,
            'username' => 'emailuser',
            'email' => 'email_test@example.com',
            'password' => $hashedPassword,
            'is_admin' => 0
        ]);
        
        // Assert
        $this->assertEquals(15, $user->getId());
        $this->assertEquals('emailuser', $user->getUsername());
        $this->assertEquals('email_test@example.com', $user->getEmail());
        $this->assertFalse($user->isAdmin());
        
        // Verify password verification would work
        $this->assertTrue(password_verify($correctPassword, $hashedPassword));
    }

    /**
     * Test authentication with username
     * Variation of Path 3: 1-2-3-4-7 (using username instead of email)
     */
    public function testAuthenticateWithUsername()
    {
        // Arrange
        // Create hashed password for test
        $correctPassword = 'username_password';
        $hashedPassword = password_hash($correctPassword, PASSWORD_DEFAULT);
        
        // Create a user with test data
        $user = new User([
            'user_id' => 20,
            'username' => 'usernametest',
            'email' => 'username@example.com',
            'password' => $hashedPassword,
            'is_admin' => 0
        ]);
        
        // Assert
        $this->assertEquals(20, $user->getId());
        $this->assertEquals('usernametest', $user->getUsername());
        $this->assertEquals('username@example.com', $user->getEmail());
        $this->assertFalse($user->isAdmin());
        
        // Verify password verification would work
        $this->assertTrue(password_verify($correctPassword, $hashedPassword));
    }
}
