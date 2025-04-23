<?php
/**
 * Direct admin access point with enhanced navigation
 * This file bypasses the normal routing to provide direct access to the admin panel
 */

// Start session
session_start();

// Check if user is logged in and is admin
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Not logged in as admin, so include the admin login file
    $admin_path = '../backend/admin/login.php';
    
    // Make sure the admin path exists
    if (file_exists($admin_path)) {
        // Include the admin login file directly
        include($admin_path);
    } else {
        echo "Error: Admin login file not found.";
    }
    exit;
}

// User is logged in as admin, show admin navigation
$current_username = $_SESSION['username'] ?? 'Unknown';
$page = $_GET['page'] ?? 'dashboard';

// Define valid admin pages
$valid_pages = [
    'dashboard' => '../backend/admin/public/admin_dashboard.php',
    'comments' => '../backend/admin/public/admin_dashboard.php', // Currently the same
    'albums' => '../backend/admin/public/admin_dashboard.php',  // Currently the same
    'artists' => '../backend/admin/public/admin_dashboard.php', // Currently the same
    'logout' => '../backend/admin/public/logout.php'
];

// Validate the requested page
if (!isset($valid_pages[$page])) {
    $page = 'dashboard';
}

// Define page titles
$page_titles = [
    'dashboard' => 'Admin Dashboard',
    'comments' => 'Manage Comments',
    'albums' => 'Manage Albums',
    'artists' => 'Manage Artists',
    'logout' => 'Logging Out...'
];

// If logout, just include the logout script
if ($page === 'logout') {
    include($valid_pages[$page]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalkTempo Admin - <?php echo htmlspecialchars($page_titles[$page]); ?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .admin-navbar {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .admin-navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .admin-navbar .nav-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .admin-navbar .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .admin-navbar a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        .admin-navbar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .admin-navbar .active {
            background-color: #4CAF50;
        }
        
        .admin-navbar .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .admin-navbar .admin-badge {
            background-color: #4CAF50;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8rem;
        }
        
        .admin-navbar .logout-btn {
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        .admin-navbar .logout-btn:hover {
            background-color: #c82333;
        }
        
        .admin-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
    </style>
</head>
<body>
    <div class="admin-navbar">
        <div class="container">
            <div class="nav-title">TalkTempo Admin</div>
            
            <div class="nav-links">
                <a href="?page=dashboard" class="<?php echo $page === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
                <a href="?page=comments" class="<?php echo $page === 'comments' ? 'active' : ''; ?>">Comments</a>
                <a href="?page=albums" class="<?php echo $page === 'albums' ? 'active' : ''; ?>">Albums</a>
                <a href="?page=artists" class="<?php echo $page === 'artists' ? 'active' : ''; ?>">Artists</a>
            </div>
            
            <div class="nav-user">
                <span class="admin-badge">Admin: <?php echo htmlspecialchars($current_username); ?></span>
                <a href="?page=logout" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>
    
    <div class="admin-content">
        <?php include($valid_pages[$page]); ?>
    </div>
</body>
</html>
