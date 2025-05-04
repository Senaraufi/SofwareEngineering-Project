<?php
/**
 * Script to view users stored in the database
 * 
 * References:
 * - W3Schools PHP MySQL Select: https://www.w3schools.com/php/php_mysql_select.asp
 * - W3Schools PHP MySQL Fetch: https://www.w3schools.com/php/php_mysql_select_fetch.asp
 * - W3Schools PHP Associative Arrays: https://www.w3schools.com/php/php_arrays_associative.asp
 * - W3Schools PHP Echo/Print: https://www.w3schools.com/php/php_echo_print.asp
 */
require_once __DIR__ . '/backend/src/config/database.php';
use App\Database;

// Get database instance
$db = Database::getInstance();

// Query users
echo "Fetching users from database...\n";
$result = $db->query('SELECT * FROM Users', []);

if ($result) {
    echo "Users found in database:\n";
    echo "-------------------------------------\n";
    echo "ID | Username | Email | Is Admin\n";
    echo "-------------------------------------\n";
    
    $users = $result->fetchAll();
    foreach($users as $user) {
        echo "{$user['user_id']} | {$user['username']} | {$user['email']} | {$user['is_admin']}\n";
    }
    echo "-------------------------------------\n";
    echo "Total users: " . count($users) . "\n";
} else {
    echo "Could not connect to database or query failed.\n";
}
