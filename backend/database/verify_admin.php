<?php
// This is a simple script to verify the admin credentials directly from the database

// Database connection settings
$host = 'localhost';
$port = 3307; // Using the port we configured
$dbname = 'talktempo';
$username = 'root';
$password = '';

// Test username and password
$test_username = 'PixieStix';
$test_password = 'root1234SQL';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Database Connection Successful!</h2>";
    
    // Get all users to check what's in the database
    $stmt = $pdo->query("SELECT user_id, username, password, is_admin FROM Users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>All Users in Database:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Username</th><th>Password</th><th>Admin</th></tr>";
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['user_id'] . "</td>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['password'] . "</td>";
        echo "<td>" . ($user['is_admin'] ? 'Yes' : 'No') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Now specifically look for the test user
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
    $stmt->bindParam(':username', $test_username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Test Login for: $test_username</h3>";
    if ($user) {
        echo "User found!<br>";
        echo "Password in DB: " . $user['password'] . "<br>";
        echo "Test Password: " . $test_password . "<br>";
        echo "Password Match: " . ($user['password'] === $test_password ? "YES" : "NO") . "<br>";
        echo "Is Admin: " . ($user['is_admin'] ? "YES" : "NO") . "<br>";
    } else {
        echo "User '$test_username' NOT found in database!";
    }
    
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
