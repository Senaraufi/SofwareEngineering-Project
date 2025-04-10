<?php

namespace App\Controllers;

use App\Controller;
use App\Database;

class UserController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function signup() {
        return $this->render('signup.html.twig', [
            'active_page' => 'signup'
        ]);
    }
    
    public function processSignup() {
        // Debug: Log the request method and POST data
        $logFile = __DIR__ . '/../../logs/signup_debug.log';
        $logDir = dirname($logFile);
        
        // Create logs directory if it doesn't exist
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Log request information
        $logData = "\n\n" . date('Y-m-d H:i:s') . " - Signup Request\n";
        $logData .= "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
        $logData .= "POST Data: " . print_r($_POST, true) . "\n";
        
        file_put_contents($logFile, $logData, FILE_APPEND);
        
        // Get form data
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $terms = isset($_POST['terms']);
        
        // Validate input
        $errors = [];
        
        if (empty($username)) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $errors['username'] = 'Username must be between 3 and 50 characters';
        } elseif ($this->usernameExists($username)) {
            $errors['username'] = 'Username already exists';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } elseif ($this->emailExists($email)) {
            $errors['email'] = 'Email already exists';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }
        
        if ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }
        
        if (!$terms) {
            $errors['terms'] = 'You must agree to the terms and conditions';
        }
        
        // If there are errors, return to the signup form with error messages
        if (!empty($errors)) {
            return $this->render('signup.html.twig', [
                'active_page' => 'signup',
                'errors' => $errors,
                'input' => [
                    'username' => $username,
                    'email' => $email
                ]
            ]);
        }
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the user into the database
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'is_admin' => 0
        ];
        
        try {
            // Log the attempt to insert user
            $logFile = __DIR__ . '/../../logs/signup_debug.log';
            file_put_contents($logFile, "Attempting to insert user: " . $username . "\n", FILE_APPEND);
            
            $userId = $this->db->insert('Users', $userData);
            
            // Log success
            file_put_contents($logFile, "User inserted successfully with ID: " . $userId . "\n", FILE_APPEND);
            
            // Set a session variable to display success message after redirect
            session_start();
            $_SESSION['signup_success'] = 'Your account has been created successfully. You can now log in.';
            
            // Redirect to login page
            header('Location: /login');
            exit;
        } catch (\Exception $e) {
            // Log error
            $logFile = __DIR__ . '/../../logs/signup_debug.log';
            file_put_contents($logFile, "Error inserting user: " . $e->getMessage() . "\n", FILE_APPEND);
            
            // Handle database error
            return $this->render('signup.html.twig', [
                'active_page' => 'signup',
                'error' => 'An error occurred while creating your account. Please try again later.',
                'input' => [
                    'username' => $username,
                    'email' => $email
                ]
            ]);
        }
    }
    
    private function usernameExists($username) {
        $user = $this->db->findOne('Users', ['username' => $username]);
        return $user !== false;
    }
    
    private function emailExists($email) {
        $user = $this->db->findOne('Users', ['email' => $email]);
        return $user !== false;
    }
    
    public function login() {
        // Start session to access session variables
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // If user is already logged in, redirect to home page
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        
        // Check if there's a success message from signup
        $success = null;
        if (isset($_SESSION['signup_success'])) {
            $success = $_SESSION['signup_success'];
            unset($_SESSION['signup_success']); // Clear the message after displaying it
        }
        
        return $this->render('login.html.twig', [
            'active_page' => 'login',
            'success' => $success
        ]);
    }
    
    public function processLogin() {
        session_start();
        
        // Get form data
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Always require password input
        if (empty($password)) {
            return $this->render('login.html.twig', [
                'active_page' => 'login',
                'error' => 'Password is required',
                'input' => ['username' => $username]
            ]);
        }
        
        if (empty($username)) {
            return $this->render('login.html.twig', [
                'active_page' => 'login',
                'error' => 'Username is required',
                'input' => ['username' => $username]
            ]);
        }

        // Check if user exists and verify password
        $user = $this->db->findOne('Users', ['username' => $username]);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['Active'] = true;

            // Redirect to dashboard
            header('Location: /dashboard');
            exit;
        }

        return $this->render('login.html.twig', [
            'active_page' => 'login',
            'error' => 'Invalid username or password',
            'input' => ['username' => $username]
        ]);
        
        // Check if user exists - use the findOne method
        $user = $this->db->findOne('Users', ['username' => $username]);
        
        // For debugging purposes
        if ($user) {
            error_log("User found: $username");
        } else {
            error_log("User not found: $username");
        }
        
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->render('login.html.twig', [
                'active_page' => 'login',
                'error' => 'Invalid username or password',
                'input' => [
                    'username' => $username
                ]
            ]);
        }
        
        // Store user data in session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        // Set a success message
        $_SESSION['login_success'] = 'You have been successfully logged in.';
        
        // Redirect to home page
        header('Location: /');
        exit;
    }
    
    public function logout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Unset all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page
        header('Location: /');
        exit;
    }
}
