<?php

namespace App\Controllers;

/**
 * UserExportController
 * 
 * Handles exporting user data to SQL files and updating schema
 * 
 * REFERENCES:
 * - PHP File Handling: https://www.w3schools.com/php/php_file_create.asp
 * - PHP Directory Functions: https://www.w3schools.com/php/php_dir_create.asp
 * - PHP Date Functions: https://www.w3schools.com/php/php_date.asp
 * - PHP String Functions: https://www.w3schools.com/php/php_string.asp
 * - PHP Database Export: https://www.w3schools.com/php/php_mysql_select.asp
 */

use App\Controller;
use App\Database;

class UserExportController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Export users to a backup SQL file
     * 
     * References:
     * - Session handling: https://www.w3schools.com/php/php_sessions.asp
     * - Directory creation: https://www.w3schools.com/php/func_filesystem_mkdir.asp
     * - File writing: https://www.w3schools.com/php/func_filesystem_file_put_contents.asp
     * - Date formatting: https://www.w3schools.com/php/func_date_date.asp
     * 
     * @return array Template rendering information
     */
    public function exportUsers() {
        // Check if user is admin (for security)
        session_start();
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            return [
                'template' => 'error.html.twig',
                'data' => [
                    'error' => 'Unauthorized access. Admin privileges required.',
                    'active_page' => 'error'
                ]
            ];
        }
        
        try {
            // Get all users from the database
            $stmt = $this->db->query("SELECT * FROM Users", []);
            
            if (!$stmt) {
                throw new \Exception("Failed to query users");
            }
            
            $users = $stmt->fetchAll();
            
            // Create the SQL export file
            $exportPath = __DIR__ . '/../../database/user_exports';
            if (!is_dir($exportPath)) {
                mkdir($exportPath, 0755, true);
            }
            
            $filename = $exportPath . '/users_export_' . date('Y-m-d_His') . '.sql';
            
            $sql = "-- TalkTempo User Export\n";
            $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "-- Insert exported users\n";
            $sql .= "INSERT INTO Users (username, password, email, phone_number, bio, profile_image_url, is_admin) VALUES \n";
            
            $values = [];
            foreach ($users as $user) {
                $values[] = sprintf("('%s', '%s', '%s', '%s', '%s', '%s', %d)",
                    addslashes($user['username']),
                    addslashes($user['password']),
                    addslashes($user['email']),
                    addslashes($user['phone_number'] ?? ''),
                    addslashes($user['bio'] ?? ''),
                    addslashes($user['profile_image_url'] ?? ''),
                    (int)$user['is_admin']
                );
            }
            
            $sql .= implode(",\n", $values) . ";\n";
            
            file_put_contents($filename, $sql);
            
            // Also update the main schema file to include the latest users
            $this->updateMainSchema($users);
            
            // Return success message
            return [
                'template' => 'admin/export_success.html.twig',
                'data' => [
                    'active_page' => 'admin',
                    'message' => 'User data exported successfully to: ' . $filename,
                    'users' => $users,
                    'count' => count($users)
                ]
            ];
            
        } catch (\Exception $e) {
            return [
                'template' => 'error.html.twig',
                'data' => [
                    'error' => 'Error exporting users: ' . $e->getMessage(),
                    'active_page' => 'error'
                ]
            ];
        }
    }
    
    /**
     * Update the main schema.sql file with current users
     * 
     * References:
     * - File reading: https://www.w3schools.com/php/func_filesystem_file_get_contents.asp
     * - String position: https://www.w3schools.com/php/func_string_strpos.asp
     * - String substring: https://www.w3schools.com/php/func_string_substr.asp
     * - Array filtering: https://www.w3schools.com/php/func_array_filter.asp
     * - String escaping: https://www.w3schools.com/php/func_string_addslashes.asp
     */
    private function updateMainSchema($users) {
        $schemaFile = __DIR__ . '/../../database/schema.sql';
        
        if (!file_exists($schemaFile) || !is_writable($schemaFile)) {
            // Skip if schema file doesn't exist or isn't writable
            return;
        }
        
        // Read the schema file
        $schema = file_get_contents($schemaFile);
        
        // Find the user insert section
        $userInsertStart = strpos($schema, "-- Insert sample users");
        if ($userInsertStart === false) {
            // Can't find the section, so skip update
            return;
        }
        
        // Find where normal user accounts begin
        $normalUsersComment = strpos($schema, "-- Normal User Accounts from here", $userInsertStart);
        if ($normalUsersComment === false) {
            // Can't find the section, so skip update
            return;
        }
        
        // Extract the admin users (founders) section
        $adminSection = substr($schema, $userInsertStart, $normalUsersComment - $userInsertStart);
        
        // Create new SQL for normal users
        $normalUsersSql = "-- Add new user accounts below this line (they will be automatically added to the database when users register)\n";
        $normalUsersSql .= "-- Normal User Accounts from here\n";
        
        $normalUsers = array_filter($users, function($user) {
            // Filter out admin users (assuming they're the founders)
            return $user['is_admin'] == 0;
        });
        
        $values = [];
        foreach ($normalUsers as $user) {
            $values[] = sprintf("('%s', '%s', '%s', '%s', '%s', '%s', %d)",
                addslashes($user['username']),
                addslashes($user['password']),
                addslashes($user['email']),
                addslashes($user['phone_number'] ?? ''),
                addslashes($user['bio'] ?? ''),
                addslashes($user['profile_image_url'] ?? ''),
                (int)$user['is_admin']
            );
        }
        
        if (!empty($values)) {
            $normalUsersSql .= implode(",\n", $values) . ";";
        }
        
        // Find where the user insert section ends
        $userInsertEnd = strpos($schema, ";", $normalUsersComment);
        if ($userInsertEnd === false) {
            // Can't find the end, so skip update
            return;
        }
        
        // Find the real end of the user insert section (next section start)
        $nextSectionStart = strpos($schema, "-- INFO FOR:", $userInsertEnd);
        if ($nextSectionStart === false) {
            // Can't find the next section, so skip update
            return;
        }
        
        // Replace the normal users section
        $newSchema = substr($schema, 0, $normalUsersComment) . $normalUsersSql . "\n\n" . 
                    substr($schema, $nextSectionStart);
        
        // Write the updated schema back to the file
        file_put_contents($schemaFile, $newSchema);
    }
    
    /**
     * Hook to automatically export users after signup
     * 
     * References:
     * - Error logging: https://www.w3schools.com/php/func_error_log.asp
     * - Directory existence check: https://www.w3schools.com/php/func_filesystem_is_dir.asp
     * - SQL formatting: https://www.w3schools.com/php/php_mysql_insert.asp
     * - String escaping with addslashes: https://www.w3schools.com/php/func_string_addslashes.asp
     */
    public static function hookAfterSignup($userId) {
        // This method could be called from UserController::processSignup
        // to export users after a new signup
        $controller = new self();
        
        try {
            // Get all users
            $stmt = $controller->db->query("SELECT * FROM Users", []);
            if ($stmt) {
                $users = $stmt->fetchAll();
                
                // Export to separate file
                $exportPath = __DIR__ . '/../../database/user_exports';
                if (!is_dir($exportPath)) {
                    mkdir($exportPath, 0755, true);
                }
                
                $filename = $exportPath . '/users_latest.sql';
                
                $sql = "-- TalkTempo User Export (Auto-generated after signup)\n";
                $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
                $sql .= "-- Current users in the system\n";
                $sql .= "INSERT INTO Users (username, password, email, phone_number, bio, profile_image_url, is_admin) VALUES \n";
                
                $values = [];
                foreach ($users as $user) {
                    $values[] = sprintf("('%s', '%s', '%s', '%s', '%s', '%s', %d)",
                        addslashes($user['username']),
                        addslashes($user['password']),
                        addslashes($user['email']),
                        addslashes($user['phone_number'] ?? ''),
                        addslashes($user['bio'] ?? ''),
                        addslashes($user['profile_image_url'] ?? ''),
                        (int)$user['is_admin']
                    );
                }
                
                $sql .= implode(",\n", $values) . ";\n";
                
                file_put_contents($filename, $sql);
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt the signup process
            error_log("Failed to export users after signup: " . $e->getMessage());
        }
    }
}
