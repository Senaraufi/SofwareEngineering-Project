<?php
// Simple database test script - place in root directory

// Database connection settings
$host = 'localhost';
$port = 3307; // Using the port we configured
$dbname = 'talktempo';
$username = 'root';
$password = '';

// Make sure there's no output buffering or template inclusion
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Database Verification</h1>";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color:green'>Database connection successful!</p>";
    
    // Get all users to check what's in the database
    $stmt = $pdo->query("SELECT user_id, username, password, is_admin FROM Users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>All Users in Database:</h3>";
    
    if (count($users) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>User ID</th><th>Username</th><th>Password</th><th>Admin</th></tr>";
        
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
            echo "<td>" . htmlspecialchars($user['password']) . "</td>";
            echo "<td>" . ($user['is_admin'] ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p><strong>No users found in database!</strong> The users table may be empty.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>Database Error: " . $e->getMessage() . "</p>";
}
?>
