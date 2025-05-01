<?php

/**
 * UserController
 * 
 * Handles user authentication, registration, and profile management.
 * 
 * References:
 * - User authentication approach: PHP Manual - Password Hashing Functions
 *   URL: https://www.php.net/manual/en/function.password-hash.php
 *   Section: "Example #1 password_hash() example"
 * 
 * - Form validation techniques: PHP: The Right Way - Data Validation
 *   URL: https://phptherightway.com/#data_validation
 * 
 * - Error handling approach: PHP & MySQL: Novice to Ninja (6th Edition)
 *   Author: Tom Butler & Kevin Yank
 *   Chapter: "Handling Errors"
 */

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
    
    /**
     * Process user signup form submission
     * 
     * References:
     * - Form handling approach: PHP & MySQL: Novice to Ninja (6th Edition)
     *   Author: Tom Butler & Kevin Yank
     *   Chapter: "Processing Forms"
     * 
     * - Logging implementation: PHP Manual - Error Handling Functions
     *   URL: https://www.php.net/manual/en/book.errorfunc.php
     *   Section: "Logging errors"
     * 
     * @return string Rendered HTML response
     */
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
        // References:
        // - Form validation approach: PHP Manual - Filter Functions
        //   URL: https://www.php.net/manual/en/book.filter.php
        //   Section: "Validating filters"
        // 
        // - Input validation best practices: OWASP Input Validation Cheat Sheet
        //   URL: https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html
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
        // Reference: PHP Manual - Password Hashing Functions
        // URL: https://www.php.net/manual/en/function.password-hash.php
        // Section: "Example #1 password_hash() example"
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
    
    /**
     * Check if session is active and valid
     * 
     * This method can be used to verify if a user is logged in
     * and optionally enforce session timeout for security
     * 
     * @param int $timeout Optional session timeout in seconds (default: 3600 = 1 hour)
     * @return bool True if session is valid, false otherwise
     */
    public function isSessionValid($timeout = 3600) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            return false;
        }
        
        // Check for session timeout if last_activity is set
        if (isset($_SESSION['last_activity'])) {
            $inactive = time() - $_SESSION['last_activity'];
            if ($inactive >= $timeout) {
                // Session has timed out, destroy it
                $this->logout();
                return false;
            }
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
        
        return true;
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
    
    /**
     * Process login form submission
     * 
     * @return string Rendered template
     */
    /**
     * Process login form submission
     * 
     * References:
     * - Session management: PHP Manual - Session Handling
     *   URL: https://www.php.net/manual/en/book.session.php
     *   Section: "Session Functions"
     * 
     * - Authentication best practices: OWASP Authentication Cheat Sheet
     *   URL: https://cheatsheetseries.owasp.org/cheatsheets/Authentication_Cheat_Sheet.html
     * 
     * @return string Rendered template or redirect
     */
    public function processLogin() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Clear any existing session data for security
        session_regenerate_id(true);
        
        // Get form data
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Validate input
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

        try {
            // Check if Users table exists
            $checkTableQuery = "SHOW TABLES LIKE 'Users'";
            $tableExists = $this->db->query($checkTableQuery)->rowCount() > 0;
            
            if (!$tableExists) {
                // Users table doesn't exist
                error_log("Users table does not exist");
                return $this->render('login.html.twig', [
                    'active_page' => 'login',
                    'error' => 'Login system is currently unavailable. Please try again later.',
                    'input' => ['username' => $username]
                ]);
            }
            
            // Check if user exists and verify password
            $user = $this->db->findOne('Users', ['username' => $username]);
            
            // For debugging purposes
            if ($user) {
                error_log("User found: $username");
            } else {
                error_log("User not found: $username");
            }
            
            // TEMPORARY: Development login bypass
            // This allows login with specific test credentials while database is being set up
            // IMPORTANT: Remove this in production!
            $devBypass = false;
            if (($username === 'admin' && $password === 'admin123') ||
                ($username === 'sena' && $password === '123456789') ||
                ($username === 'test' && $password === 'test123')) {
                $devBypass = true;
                $user = [
                    'user_id' => 1,
                    'username' => $username,
                    'is_admin' => ($username === 'admin') ? 1 : 0
                ];
                error_log("DEVELOPMENT MODE: Login bypass activated for user: $username");
            }

            if (($user && password_verify($password, $user['password'])) || $devBypass) {
                // Set session variables with enhanced security
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);
                
                // Store user information in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['Active'] = true;
                $_SESSION['login_time'] = time();
                $_SESSION['last_activity'] = time();
                
                // Set admin flag if applicable
                if (isset($user['is_admin']) && $user['is_admin'] == 1) {
                    $_SESSION['is_admin'] = true;
                }
                
                // Log successful login
                error_log("User login successful: {$user['username']} (ID: {$user['user_id']})");

                // Redirect to dashboard or home page
                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard';
                header('Location: /' . $redirect);
                exit;
            }

            return $this->render('login.html.twig', [
                'active_page' => 'login',
                'error' => 'Invalid username or password',
                'input' => ['username' => $username]
            ]);
        } catch (\Exception $e) {
            // Log database error
            error_log("Database error in processLogin: " . $e->getMessage());
            
            // Return error message to user
            return $this->render('login.html.twig', [
                'active_page' => 'login',
                'error' => 'Login system is currently unavailable. Please try again later.',
                'input' => ['username' => $username]
            ]);
        }
    }
    
    /**
     * Logout user and destroy session
     * 
     * References:
     * - Secure logout implementation: PHP Manual - Session Security
     *   URL: https://www.php.net/manual/en/session.security.php
     *   Section: "Session and Cookie Hijacking"
     * 
     * - OWASP Session Management Cheat Sheet
     *   URL: https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html
     *   Section: "Session Expiration"
     */
    public function logout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Log the logout event if user was logged in
        if (isset($_SESSION['username'])) {
            error_log("User logout: {$_SESSION['username']} (ID: {$_SESSION['user_id']})");
        }
        
        // Unset all session variables
        $_SESSION = [];
        
        // If a session cookie is used, destroy it
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page with logout message
        header('Location: /?msg=logout_success');
        exit;
    }
}
