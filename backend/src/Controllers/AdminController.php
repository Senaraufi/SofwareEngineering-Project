<?php

namespace App\Controllers;

use App\Controller;
use App\Database;

class AdminController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function users() {
        // Check if user is logged in and is an admin
        session_start();
        if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            header('Location: /login');
            exit;
        }
        
        // Get all users from the database
        $pdo = $this->db->getConnection();
        $stmt = $pdo->query("SELECT * FROM Users ORDER BY user_id");
        $users = $stmt->fetchAll();
        
        return $this->render('admin/users.html.twig', [
            'active_page' => 'admin',
            'users' => $users
        ]);
    }
    
    public function editUser($userId) {
        // Check if user is logged in and is an admin
        session_start();
        if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            header('Location: /login');
            exit;
        }
        
        // Get user from the database
        $user = $this->db->findOne('Users', ['user_id' => $userId]);
        
        if (!$user) {
            return $this->render('admin/users.html.twig', [
                'active_page' => 'admin',
                'error' => 'User not found',
                'users' => []
            ]);
        }
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $isAdmin = isset($_POST['is_admin']) ? 1 : 0;
            
            // Update user in the database
            $pdo = $this->db->getConnection();
            $stmt = $pdo->prepare("UPDATE Users SET username = ?, email = ?, is_admin = ? WHERE user_id = ?");
            $stmt->execute([$username, $email, $isAdmin, $userId]);
            
            // Redirect to users page
            header('Location: /admin/users?success=User updated successfully');
            exit;
        }
        
        return $this->render('admin/edit_user.html.twig', [
            'active_page' => 'admin',
            'user' => $user
        ]);
    }
    
    public function deleteUser($userId) {
        // Check if user is logged in and is an admin
        session_start();
        if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
            header('Location: /login');
            exit;
        }
        
        // Delete user from the database
        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("DELETE FROM Users WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // Redirect to users page
        header('Location: /admin/users?success=User deleted successfully');
        exit;
    }
}
