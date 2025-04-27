<?php

namespace Tests\TestsAssignment4\Validation;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Album;
use App\Models\Concert;
use App\Models\Review;

class ValidationTests extends TestCase
{
    private $mockDb;

    protected function setUp(): void
    {
        // Create a mock database connection
        $this->mockDb = $this->createMock(\App\Database::class);
    }

    /**
     * Test 1: Email Validation
     * This test validates email formats for user registration
     */
    public function testEmailValidation()
    {
        $user = new User($this->mockDb);
        
        // Test invalid email formats
        $invalidEmails = [
            'plainaddress',                 // Missing @ and domain
            '@missingusername.com',         // Missing username
            'user@.com',                    // Missing domain
            'user@domain',                  // Missing TLD
            'user@domain..com',             // Double dots
            'user@domain@domain.com',       // Multiple @ symbols
            'user@domain.com.',             // Trailing dot
            'user name@domain.com',         // Space in username
            'user@domain_name.com',         // Underscore in domain
            str_repeat('a', 65) . '@domain.com', // Username too long
        ];
        
        foreach ($invalidEmails as $email) {
            $user->email = $email;
            $this->assertFalse($user->validateEmail(), "Email should be invalid: $email");
        }
        
        // Test valid email formats
        $validEmails = [
            'user@domain.com',
            'user.name@domain.com',
            'user-name@domain.com',
            'user_name@domain.com',
            'user123@domain.com',
            'user@subdomain.domain.com',
            'user@domain-name.com',
            'user@domain.co.uk',
        ];
        
        foreach ($validEmails as $email) {
            $user->email = $email;
            $this->assertTrue($user->validateEmail(), "Email should be valid: $email");
        }
    }

    /**
     * Test 2: Password Strength Validation
     * This test validates password strength requirements
     */
    public function testPasswordStrengthValidation()
    {
        $user = new User($this->mockDb);
        
        // Test invalid passwords
        $invalidPasswords = [
            'short',                        // Too short
            'onlylowercase',                // No uppercase, numbers or special chars
            'ONLYUPPERCASE',                // No lowercase, numbers or special chars
            'onlyLowerAndUpper',            // No numbers or special chars
            '12345678',                     // Only numbers
            'password123',                  // Common password pattern
            str_repeat('a', 101),           // Too long
        ];
        
        foreach ($invalidPasswords as $password) {
            $this->assertFalse($user->validatePasswordStrength($password), "Password should be invalid: $password");
        }
        
        // Test valid passwords
        $validPasswords = [
            'StrongP@ssw0rd',               // Mix of everything
            'Secure_Password123',           // Mix with underscore
            'C0mpl3x!P@ssw0rd',             // Complex with special chars
            'N0t-S0-E@sy-T0-Gu3ss',         // With hyphens
            'ThisIs@V3ryStr0ngP@ssw0rd',    // Longer password
        ];
        
        foreach ($validPasswords as $password) {
            $this->assertTrue($user->validatePasswordStrength($password), "Password should be valid: $password");
        }
    }

    /**
     * Test 3: Concert Date Validation
     * This test validates that concert dates are in the future
     */
    public function testConcertDateValidation()
    {
        $concert = new Concert($this->mockDb);
        
        // Test invalid dates (past dates)
        $invalidDates = [
            date('Y-m-d H:i:s', strtotime('-1 day')),     // Yesterday
            date('Y-m-d H:i:s', strtotime('-1 week')),    // Last week
            date('Y-m-d H:i:s', strtotime('-1 month')),   // Last month
            date('Y-m-d H:i:s', strtotime('-1 year')),    // Last year
            '2020-01-01 12:00:00',                        // Fixed past date
        ];
        
        foreach ($invalidDates as $date) {
            $concert->date = $date;
            $this->assertFalse($concert->validateFutureDate(), "Date should be invalid (past date): $date");
        }
        
        // Test valid dates (future dates)
        $validDates = [
            date('Y-m-d H:i:s', strtotime('+1 day')),     // Tomorrow
            date('Y-m-d H:i:s', strtotime('+1 week')),    // Next week
            date('Y-m-d H:i:s', strtotime('+1 month')),   // Next month
            date('Y-m-d H:i:s', strtotime('+1 year')),    // Next year
            '2030-01-01 12:00:00',                        // Fixed future date
        ];
        
        foreach ($validDates as $date) {
            $concert->date = $date;
            $this->assertTrue($concert->validateFutureDate(), "Date should be valid (future date): $date");
        }
    }

    /**
     * Test 4: Price Range Validation
     * This test validates that album prices are within acceptable ranges
     */
    public function testPriceRangeValidation()
    {
        $album = new Album($this->mockDb);
        
        // Test invalid prices
        $invalidPrices = [
            -10.00,        // Negative price
            0.00,          // Zero price
            0.50,          // Too low price
            1000.01,       // Too high price
            5000.00,       // Extremely high price
        ];
        
        foreach ($invalidPrices as $price) {
            $album->price = $price;
            $this->assertFalse($album->validatePriceRange(), "Price should be invalid: $price");
        }
        
        // Test valid prices
        $validPrices = [
            1.00,          // Minimum valid price
            9.99,          // Common price
            19.99,         // Common price
            49.99,         // Higher price
            99.99,         // Higher price
            1000.00,       // Maximum valid price
        ];
        
        foreach ($validPrices as $price) {
            $album->price = $price;
            $this->assertTrue($album->validatePriceRange(), "Price should be valid: $price");
        }
    }

    /**
     * Test 5: Review Content Validation
     * This test validates review content for appropriate length and content
     */
    public function testReviewContentValidation()
    {
        $review = new Review($this->mockDb);
        
        // Test invalid review contents
        $invalidContents = [
            '',                                // Empty content
            'Too short',                       // Too short
            str_repeat('a', 10),               // Too short with repetition
            str_repeat('a', 2001),             // Too long
            'This review contains inappropriate content like ****',  // Contains profanity
        ];
        
        foreach ($invalidContents as $content) {
            $review->content = $content;
            $this->assertFalse($review->validateContent(), "Review content should be invalid: " . (strlen($content) > 20 ? substr($content, 0, 20) . '...' : $content));
        }
        
        // Test valid review contents
        $validContents = [
            'This is a valid review with sufficient length to pass the validation check.',
            'I really enjoyed this album. The production quality was excellent and the lyrics were meaningful.',
            'The concert was amazing! The venue was perfect and the sound quality was exceptional.',
            str_repeat('a', 50),               // Minimum valid length
            str_repeat('a', 2000),             // Maximum valid length
        ];
        
        foreach ($validContents as $content) {
            $review->content = $content;
            $this->assertTrue($review->validateContent(), "Review content should be valid: " . (strlen($content) > 20 ? substr($content, 0, 20) . '...' : $content));
        }
    }
}
