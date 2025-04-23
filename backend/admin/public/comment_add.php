<?php
/**
* This code is citied and adapted from code provided by Robert Smith and Tania Malik, and it is apart of our course material in our Web Devlopment Server Side module
*/

// Start session
session_start();

// Check if user is logged in and is admin
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../login.php");
    exit;
}

require "../common.php";
require_once '../src/DBconnect.php';

// Process form submission
if (isset($_POST['submit'])) {
    try {
        // Get form data
        $review_id = escape($_POST['review_id']);
        $content = escape($_POST['content']);
        $user_id = $_SESSION['user_id']; // Current admin user
        
        // Insert new comment
        $sql = "INSERT INTO Comments (review_id, user_id, content) 
                VALUES (:review_id, :user_id, :content)";
        
        $statement = $connection->prepare($sql);
        $statement->bindParam(':review_id', $review_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':content', $content, PDO::PARAM_STR);
        
        $statement->execute();
        
        // Redirect back to dashboard with success message
        header("Location: admin_dashboard.php?message=Comment+added+successfully");
        exit;
    } catch(PDOException $error) {
        // Redirect back with error
        header("Location: admin_dashboard.php?error=" . urlencode($error->getMessage()));
        exit;
    }
} else {
    // If accessed directly without form submission
    header("Location: admin_dashboard.php");
    exit;
}
?>
