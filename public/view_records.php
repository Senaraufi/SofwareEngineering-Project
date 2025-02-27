<?php
require_once '../backend/includes/config/database.php';

try {
    $db = new SQLite3('../backend/database/talktempo.db');
    
    // Create tables if they don't exist
    $db->exec(file_get_contents('../backend/database/schema.sql'));
    
    // Fetch and display users
    echo "<h2>Users</h2>";
    $results = $db->query('SELECT user_id, username, email, is_admin FROM Users');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        echo "User: " . htmlspecialchars($row['username']) . 
             " (Email: " . htmlspecialchars($row['email']) . ")<br>";
    }
    
    // Fetch and display comments
    echo "<h2>Comments</h2>";
    $results = $db->query('SELECT c.content, u.username FROM Comments c JOIN Users u ON c.user_id = u.user_id');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        echo "Comment by " . htmlspecialchars($row['username']) . ": " . 
             htmlspecialchars($row['content']) . "<br>";
    }
    
    // Fetch and display content
    echo "<h2>Content</h2>";
    $results = $db->query('SELECT c.title, c.body, u.username FROM Content c JOIN Users u ON c.created_by = u.user_id');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        echo "<strong>" . htmlspecialchars($row['title']) . "</strong> by " . 
             htmlspecialchars($row['username']) . "<br>" .
             htmlspecialchars($row['body']) . "<br><br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
