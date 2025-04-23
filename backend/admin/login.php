<?php
/**
* This code is citied and adapted from code provided by Robert Smith and Tania Malik, and it is apart of our course material in our Web Devlopment Server Side module
*/

// Start session
session_start();

// Include database connection
require_once 'src/DBconnect.php';
require_once 'common.php';

// Check if user is already logged in
if(isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    header("Location: /admin_access.php");
    exit;
}

// Process login form
$error_message = '';
$debug_message = ''; // Added for debugging

if (isset($_POST['submit'])) {
    $username = escape($_POST['username']);
    $password = $_POST['password']; // We'll directly compare in this simplified version
    
    // Always show debugging information
    $debug_message = "Attempting login with: Username='$username', Password='$password'";
    $debug_message .= "<br>Connection details: Using " . $connection->getAttribute(PDO::ATTR_DRIVER_NAME) . " connection";
    
    try {
        // First, let's check if the database has users at all
        $check_sql = "SELECT COUNT(*) as user_count FROM Users";
        $check_stmt = $connection->query($check_sql);
        $user_count = $check_stmt->fetch(PDO::FETCH_ASSOC);
        $debug_message .= "<br>Total users in database: " . $user_count['user_count'];

        // Query to check for admin user
        $sql = "SELECT user_id, username, password, is_admin FROM Users WHERE username = :username";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Debug info
        if ($user) {
            $debug_message .= "<br>Found user: {$user['username']}, Admin: " . ($user['is_admin'] ? 'Yes' : 'No');
            $debug_message .= "<br>Password in DB: '{$user['password']}'"; 
            $debug_message .= "<br>Password input: '$password'";
            $debug_message .= "<br>Exact match: " . ($user['password'] === $password ? 'Yes' : 'No');
            $debug_message .= "<br>Case insensitive match: " . (strtolower($user['password']) === strtolower($password) ? 'Yes' : 'No');
        } else {
            $debug_message .= "<br>No user found with username: '$username'";
            
            // Let's check if there's a case-insensitive match
            $case_sql = "SELECT username FROM Users WHERE LOWER(username) = LOWER(:username)";
            $case_stmt = $connection->prepare($case_sql);
            $case_stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $case_stmt->execute();
            $case_user = $case_stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($case_user) {
                $debug_message .= "<br>Found case-insensitive match: '{$case_user['username']}'";
            }
        }
        
        // Modified comparison logic - try case-insensitive matching and check if admin
        if ($user) {
            // Try exact match first
            if ($user['password'] === $password && $user['is_admin'] == 1) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                header("Location: /admin_access.php");
                exit;
            }
            // Try case-insensitive match
            else if (strtolower($user['password']) === strtolower($password) && $user['is_admin'] == 1) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                $debug_message .= "<br>Logged in with case-insensitive password match.";
                header("Location: /admin_access.php");
                exit;
            }
            else {
                $error_message = "Invalid password or you don't have admin privileges";
            }
        } else {
            $error_message = "Username not found";
        }
    } catch(PDOException $error) {
        $error_message = "Database error: " . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .debug {
            color: blue;
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        
        <?php if ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($debug_message): ?>
            <div class="debug"><?php echo $debug_message; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" name="submit" value="Login">
        </form>
        
        <p><a href="public/index.php">Back to Main Site</a></p>
    </div>
</body>
</html>
