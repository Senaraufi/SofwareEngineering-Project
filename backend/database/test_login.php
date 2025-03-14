<?php

// This script tests the login functionality directly

// Database connection parameters
$host = 'localhost';
$dbname = 'talktempo';
$username = 'root';
$password = '';

echo "Testing login functionality...\n\n";

// Test username and password
$testUsername = 'testuser';
$testPassword = 'password123';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the user exists
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->execute([$testUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User found: " . $user['username'] . "\n";
        echo "User ID: " . $user['user_id'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Password hash: " . $user['password'] . "\n\n";
        
        // Verify password
        $passwordVerified = password_verify($testPassword, $user['password']);
        echo "Password verification: " . ($passwordVerified ? "SUCCESS" : "FAILED") . "\n";
        
        if ($passwordVerified) {
            echo "Login would be successful!\n";
        } else {
            echo "Login would fail due to incorrect password.\n";
        }
    } else {
        echo "User not found: $testUsername\n";
        echo "Login would fail due to user not found.\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
