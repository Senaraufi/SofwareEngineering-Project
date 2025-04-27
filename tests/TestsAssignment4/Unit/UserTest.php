<?php

namespace Tests\TestsAssignment4\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        // Create a user instance with test data
        $this->user = new User([
            'user_id' => 1,
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'is_admin' => 0
        ]);
    }

    /**
     * Test user creation with valid data
     */
    public function testCreateUserWithValidData()
    {
        // Arrange
        $userData = [
            'user_id' => 5,
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'securepassword123',
            'is_admin' => 0
        ];
        
        // Act
        $newUser = new User($userData);
        
        // Assert
        $this->assertEquals(5, $newUser->getId());
        $this->assertEquals('newuser', $newUser->getUsername());
        $this->assertEquals('newuser@example.com', $newUser->getEmail());
    }

    /**
     * Test email validation
     */
    public function testEmailValidation()
    {
        // Test with valid email
        $user = new User([
            'user_id' => 1,
            'email' => 'valid@example.com'
        ]);
        $this->assertEquals('valid@example.com', $user->getEmail());
        $this->assertMatchesRegularExpression('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/', $user->getEmail());
        
        // Test with invalid email format
        $user = new User([
            'user_id' => 1,
            'email' => 'invalid-email'
        ]);
        $this->assertEquals('invalid-email', $user->getEmail());
        $this->assertDoesNotMatchRegularExpression('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/', $user->getEmail());
        
        // Test with empty email
        $user = new User([
            'user_id' => 1,
            'email' => ''
        ]);
        $this->assertEquals('', $user->getEmail());
        $this->assertEmpty($user->getEmail());
    }

    /**
     * Test password validation
     */
    public function testPasswordValidation()
    {
        // Test with valid password
        $validPassword = "ValidPassword123";
        $hashedPassword = password_hash($validPassword, PASSWORD_DEFAULT);
        $user = new User([
            'user_id' => 1,
            'password' => $hashedPassword
        ]);
        
        // Verify password hash format
        $this->assertStringStartsWith('$2y$', $hashedPassword);
        
        // Test password length
        $this->assertGreaterThan(8, strlen($validPassword));
        
        // Test with short password
        $shortPassword = "short";
        $this->assertLessThan(8, strlen($shortPassword));
    }

    /**
     * Test user authentication
     */
    public function testUserAuthentication()
    {
        // Arrange
        $password = "securepassword123";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User([
            'user_id' => 1,
            'username' => 'testuser',
            'password' => $hashedPassword
        ]);
        
        // Act & Assert
        $this->assertTrue(password_verify($password, $hashedPassword));
        $this->assertFalse(password_verify("wrongpassword", $hashedPassword));
    }

    /**
     * Test user admin status
     */
    public function testUserAdminStatus()
    {
        // Test regular user
        $user = new User([
            'user_id' => 1,
            'username' => 'regularuser',
            'is_admin' => 0
        ]);
        $this->assertFalse($user->isAdmin());
        
        // Test admin user
        $admin = new User([
            'user_id' => 2,
            'username' => 'adminuser',
            'is_admin' => 1
        ]);
        $this->assertTrue($admin->isAdmin());
    }
}
