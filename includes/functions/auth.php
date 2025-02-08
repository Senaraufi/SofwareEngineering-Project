<?php
require_once __DIR__ . '/../config/database.php';

function registerUser($username, $email, $password) {
    $conn = connectDB();
    if (!$conn) return false;

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hash);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $success;
}

function loginUser($email, $password) {
    $conn = connectDB();
    if (!$conn) return false;
    
    // Prepare statement
    $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    
    $stmt->close();
    $conn->close();
    
    return false;
}

function logoutUser() {
    session_start();
    session_destroy();
    return true;
}

function isLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}
?>
