<?php

// Database connection parameters
$host = 'localhost';
$dbname = 'talktempo';
$username = 'root';
$password = '';

echo "Making test user an admin...\n";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Update the test user to be an admin
    $stmt = $pdo->prepare("UPDATE Users SET is_admin = 1 WHERE username = ?");
    $stmt->execute(['testuser']);
    
    if ($stmt->rowCount() > 0) {
        echo "Success! The user 'testuser' is now an admin.\n";
        echo "You can now log in with:\n";
        echo "Username: testuser\n";
        echo "Password: password123\n";
        echo "And access the admin panel at: http://localhost:8000/admin/users\n";
    } else {
        echo "No user with username 'testuser' was found.\n";
        
        // Create an admin user if none exists
        echo "Creating a new admin user...\n";
        
        // Hash the password
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        
        // Insert the admin user
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@example.com', $hashedPassword, 1]);
        
        echo "Success! Created a new admin user.\n";
        echo "You can now log in with:\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
        echo "And access the admin panel at: http://localhost:8000/admin/users\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
