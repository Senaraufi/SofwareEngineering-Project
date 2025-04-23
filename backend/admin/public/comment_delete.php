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

// Check if comment ID is provided
if (isset($_GET['id'])) {
    try {
        // Get comment ID
        $comment_id = $_GET['id'];
        
        // Delete the comment
        $sql = "DELETE FROM Comments WHERE comment_id = :comment_id";
        
        $statement = $connection->prepare($sql);
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        
        $statement->execute();
        
        // Redirect back to dashboard with success message
        header("Location: admin_dashboard.php?message=Comment+deleted+successfully");
        exit;
    } catch(PDOException $error) {
        // Redirect back with error
        header("Location: admin_dashboard.php?error=" . urlencode($error->getMessage()));
        exit;
    }
} else {
    // If accessed without comment ID
    header("Location: admin_dashboard.php?error=No+comment+selected");
    exit;
}
?>
