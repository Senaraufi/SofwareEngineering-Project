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

// Get current admin's username for display
$current_username = $_SESSION['username'];

// Get all comments with related user and review info
try {
    $sql = "SELECT c.comment_id, c.content, c.created_at, c.updated_at, 
            u.username, u.is_admin, r.title as review_title, 
            a.title as album_title, con.name as concert_name
            FROM Comments c
            JOIN Users u ON c.user_id = u.user_id
            JOIN Reviews r ON c.review_id = r.review_id
            LEFT JOIN Albums a ON r.album_id = a.album_id
            LEFT JOIN Concerts con ON r.concert_id = con.concert_id
            ORDER BY c.created_at DESC";
    
    $statement = $connection->prepare($sql);
    $statement->execute();
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

// Get all reviews for the "Add Comment" form
try {
    $sql = "SELECT r.review_id, r.title, 
            COALESCE(a.title, con.name) as item_name,
            CASE WHEN a.title IS NOT NULL THEN 'Album' ELSE 'Concert' END as item_type
            FROM Reviews r
            LEFT JOIN Albums a ON r.album_id = a.album_id
            LEFT JOIN Concerts con ON r.concert_id = con.concert_id
            ORDER BY r.created_at DESC";
    
    $statement = $connection->prepare($sql);
    $statement->execute();
    $reviews = $statement->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

// Get success or error messages from URL parameters
$success_message = isset($_GET['message']) ? $_GET['message'] : '';
$error_message = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Comment Management</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .admin-badge {
            background-color: #444;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.8em;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .comment-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9em;
            color: #666;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .admin-user {
            color: #d32f2f;
            font-weight: bold;
        }
        
        .regular-user {
            color: #2196f3;
        }
        
        .comment-text {
            margin-bottom: 10px;
        }
        
        .comment-meta {
            font-size: 0.8em;
            color: #777;
        }
        
        .action-links a {
            margin-left: 10px;
            color: #f44336;
            text-decoration: none;
        }
        
        .action-links a:hover {
            text-decoration: underline;
        }
        
        .form-container {
            max-width: 600px;
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        
        select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        textarea {
            height: 100px;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .logout-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard - Comment Management</h1>
            <div>
                <span class="admin-badge">Admin: <?php echo escape($current_username); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
        
        <?php if (!empty($success_message)): ?>
            <div class="message success">
                <?php echo escape($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="message error">
                <?php echo escape($error_message); ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h2>Add New Comment</h2>
            <div class="form-container">
                <form action="comment_add.php" method="post">
                    <div class="form-group">
                        <label for="review_id">Select Review:</label>
                        <select name="review_id" id="review_id" required>
                            <option value="">-- Select a Review --</option>
                            <?php foreach ($reviews as $review): ?>
                                <option value="<?php echo $review['review_id']; ?>">
                                    <?php echo escape($review['title']); ?> 
                                    (<?php echo escape($review['item_type'] . ': ' . $review['item_name']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Comment:</label>
                        <textarea name="content" id="content" required></textarea>
                    </div>
                    
                    <button type="submit" name="submit">Add Comment</button>
                </form>
            </div>
        </div>
        
        <div class="section">
            <h2>All Comments</h2>
            
            <?php if (isset($comments) && !empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-box">
                        <div class="comment-header">
                            <div class="user-info">
                                <span class="<?php echo $comment['is_admin'] ? 'admin-user' : 'regular-user'; ?>">
                                    <?php echo escape($comment['username']); ?>
                                    <?php if ($comment['is_admin']): ?>(Admin)<?php endif; ?>
                                </span>
                            </div>
                            
                            <div class="action-links">
                                <a href="comment_delete.php?id=<?php echo $comment['comment_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this comment?');">
                                    Delete
                                </a>
                            </div>
                        </div>
                        
                        <div class="comment-text">
                            <?php echo escape($comment['content']); ?>
                        </div>
                        
                        <div class="comment-meta">
                            <div>
                                <strong>Review:</strong> <?php echo escape($comment['review_title']); ?>
                                <?php if (!empty($comment['album_title'])): ?>
                                    (Album: <?php echo escape($comment['album_title']); ?>)
                                <?php elseif (!empty($comment['concert_name'])): ?>
                                    (Concert: <?php echo escape($comment['concert_name']); ?>)
                                <?php endif; ?>
                            </div>
                            <div>
                                <strong>Posted:</strong> <?php echo escape($comment['created_at']); ?>
                                <?php if ($comment['updated_at'] != $comment['created_at']): ?>
                                    <strong>Updated:</strong> <?php echo escape($comment['updated_at']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
