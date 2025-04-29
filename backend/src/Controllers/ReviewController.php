<?php

namespace App\Controllers;

use App\Controller;
use App\Database;
use App\Models\Review;
use App\Models\Album;
use App\Models\User;

class ReviewController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Display reviews for an album
     * 
     * @param int $albumId Album ID
     * @return string Rendered template
     */
    public function albumReviews($albumId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Try to get album details, handle potential database issues
        try {
            // Check if the Albums table exists
            $checkTableQuery = "SHOW TABLES LIKE 'Albums'";
            $tableExists = $this->db->query($checkTableQuery)->rowCount() > 0;
            
            if (!$tableExists) {
                // Albums table doesn't exist, use hardcoded data
                $album = $this->getHardcodedAlbum($albumId);
                $reviews = [];
                $userHasReviewed = false;
            } else {
                // Get album details
                $albumQuery = "SELECT * FROM Albums WHERE album_id = ?";
                $album = $this->db->query($albumQuery, [$albumId])->fetch();
                
                if (!$album) {
                    // Album not found, use hardcoded data
                    $album = $this->getHardcodedAlbum($albumId);
                    $reviews = [];
                    $userHasReviewed = false;
                } else {
                    // Check if Reviews table exists
                    $checkReviewsTableQuery = "SHOW TABLES LIKE 'Reviews'";
                    $reviewsTableExists = $this->db->query($checkReviewsTableQuery)->rowCount() > 0;
                    
                    if (!$reviewsTableExists) {
                        // Reviews table doesn't exist, use empty array
                        $reviews = [];
                        $userHasReviewed = false;
                    } else {
                        // Get reviews for this album
                        $reviewsQuery = "SELECT r.*, u.username, u.profile_image 
                                         FROM Reviews r 
                                         JOIN Users u ON r.user_id = u.user_id 
                                         WHERE r.album_id = ? 
                                         ORDER BY r.created_at DESC";
                        $reviews = $this->db->query($reviewsQuery, [$albumId])->fetchAll();
                        
                        // Check if user has already reviewed this album
                        $userHasReviewed = false;
                        if (isset($_SESSION['user_id'])) {
                            $checkQuery = "SELECT COUNT(*) as count FROM Reviews 
                                          WHERE album_id = ? AND user_id = ?";
                            $result = $this->db->query($checkQuery, [$albumId, $_SESSION['user_id']])->fetch();
                            $userHasReviewed = $result['count'] > 0;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle database error by using hardcoded data
            error_log("Database error in albumReviews: " . $e->getMessage());
            $album = $this->getHardcodedAlbum($albumId);
            $reviews = [];
            $userHasReviewed = false;
        }
        
        return $this->render('reviews.html.twig', [
            'active_page' => 'albums',
            'album' => $album,
            'reviews' => $reviews,
            'user_has_reviewed' => $userHasReviewed,
            'is_logged_in' => isset($_SESSION['Active']) && $_SESSION['Active'] === true
        ]);
    }
    
    /**
     * Display form to add a new review
     * 
     * @param int $albumId Album ID
     * @return string Rendered template
     */
    public function newReview($albumId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=album/' . $albumId . '/review/new');
            exit;
        }
        
        try {
            // Check if the Albums table exists
            $checkTableQuery = "SHOW TABLES LIKE 'Albums'";
            $tableExists = $this->db->query($checkTableQuery)->rowCount() > 0;
            
            if (!$tableExists) {
                // Albums table doesn't exist, use hardcoded data
                $album = $this->getHardcodedAlbum($albumId);
                $userHasReviewed = false;
            } else {
                // Get album details
                $albumQuery = "SELECT * FROM Albums WHERE album_id = ?";
                $album = $this->db->query($albumQuery, [$albumId])->fetch();
                
                if (!$album) {
                    // Album not found, use hardcoded data
                    $album = $this->getHardcodedAlbum($albumId);
                    $userHasReviewed = false;
                } else {
                    // Check if Reviews table exists
                    $checkReviewsTableQuery = "SHOW TABLES LIKE 'Reviews'";
                    $reviewsTableExists = $this->db->query($checkReviewsTableQuery)->rowCount() > 0;
                    
                    if (!$reviewsTableExists) {
                        // Reviews table doesn't exist
                        $userHasReviewed = false;
                    } else {
                        // Check if user has already reviewed this album
                        $checkQuery = "SELECT COUNT(*) as count FROM Reviews 
                                      WHERE album_id = ? AND user_id = ?";
                        $result = $this->db->query($checkQuery, [$albumId, $_SESSION['user_id']])->fetch();
                        
                        if ($result['count'] > 0) {
                            // User has already reviewed this album, redirect to reviews page
                            header('Location: /album/' . $albumId . '/reviews?msg=already_reviewed');
                            exit;
                        }
                        $userHasReviewed = false;
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle database error by using hardcoded data
            error_log("Database error in newReview: " . $e->getMessage());
            $album = $this->getHardcodedAlbum($albumId);
            $userHasReviewed = false;
        }
        
        return $this->render('review_form.html.twig', [
            'active_page' => 'albums',
            'album' => $album,
            'action' => 'new'
        ]);
    }
    
    /**
     * Process new review submission
     * 
     * @param int $albumId Album ID
     * @return void
     */
    public function submitReview($albumId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=album/' . $albumId . '/review/new');
            exit;
        }
        
        // Get form data
        $rating = isset($_POST['rating']) ? (float)$_POST['rating'] : 0;
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        
        // Validate input
        $errors = [];
        
        if ($rating < 0.5 || $rating > 5) {
            $errors['rating'] = 'Rating must be between 0.5 and 5';
        }
        
        if (empty($title)) {
            $errors['title'] = 'Title is required';
        } elseif (strlen($title) > 100) {
            $errors['title'] = 'Title must be less than 100 characters';
        }
        
        if (empty($content)) {
            $errors['content'] = 'Review content is required';
        }
        
        try {
            // Check if the Albums table exists
            $checkTableQuery = "SHOW TABLES LIKE 'Albums'";
            $tableExists = $this->db->query($checkTableQuery)->rowCount() > 0;
            
            if (!$tableExists) {
                // Albums table doesn't exist, use hardcoded data
                $album = $this->getHardcodedAlbum($albumId);
            } else {
                // Get album details for rendering the form if there are errors
                $albumQuery = "SELECT * FROM Albums WHERE album_id = ?";
                $album = $this->db->query($albumQuery, [$albumId])->fetch();
                
                if (!$album) {
                    // Album not found, use hardcoded data
                    $album = $this->getHardcodedAlbum($albumId);
                }
            }
            
            // If there are errors, return to the form with error messages
            if (!empty($errors)) {
                return $this->render('review_form.html.twig', [
                    'active_page' => 'albums',
                    'album' => $album,
                    'action' => 'new',
                    'errors' => $errors,
                    'input' => [
                        'rating' => $rating,
                        'title' => $title,
                        'content' => $content
                    ]
                ]);
            }
            
            // Check if Reviews table exists
            $checkReviewsTableQuery = "SHOW TABLES LIKE 'Reviews'";
            $reviewsTableExists = $this->db->query($checkReviewsTableQuery)->rowCount() > 0;
            
            if (!$reviewsTableExists) {
                // Reviews table doesn't exist, show error
                return $this->render('review_form.html.twig', [
                    'active_page' => 'albums',
                    'album' => $album,
                    'action' => 'new',
                    'error' => 'The review system is currently unavailable. Please try again later.',
                    'input' => [
                        'rating' => $rating,
                        'title' => $title,
                        'content' => $content
                    ]
                ]);
            }
            
            // Check if user has already reviewed this album
            $checkQuery = "SELECT COUNT(*) as count FROM Reviews 
                          WHERE album_id = ? AND user_id = ?";
            $result = $this->db->query($checkQuery, [$albumId, $_SESSION['user_id']])->fetch();
            
            if ($result['count'] > 0) {
                // User has already reviewed this album, redirect to reviews page
                header('Location: /album/' . $albumId . '/reviews?msg=already_reviewed');
                exit;
            }
            
            // Insert the review into the database
            $reviewData = [
                'user_id' => $_SESSION['user_id'],
                'album_id' => $albumId,
                'rating' => $rating,
                'title' => $title,
                'content' => $content,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $insertQuery = "INSERT INTO Reviews (user_id, album_id, rating, title, content, created_at, updated_at) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
            $this->db->query($insertQuery, [
                $_SESSION['user_id'], $albumId, $rating, $title, $content, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')
            ]);
            
            // Redirect to album reviews page with success message
            header('Location: /album/' . $albumId . '/reviews?msg=review_added');
            exit;
        } catch (\Exception $e) {
            // Log error
            error_log("Error in submitReview: " . $e->getMessage());
            
            // Get album data for the form (fallback to hardcoded if needed)
            $album = $this->getHardcodedAlbum($albumId);
            
            // Return to form with error message
            return $this->render('review_form.html.twig', [
                'active_page' => 'albums',
                'album' => $album,
                'action' => 'new',
                'error' => 'An error occurred while submitting your review. Please try again later.',
                'input' => [
                    'rating' => $rating,
                    'title' => $title,
                    'content' => $content
                ]
            ]);
        }
    }
    
    /**
     * Display form to edit a review
     * 
     * @param int $reviewId Review ID
     * @return string Rendered template
     */
    public function editReview($reviewId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required');
            exit;
        }
        
        try {
            // Check if Reviews table exists
            $checkReviewsTableQuery = "SHOW TABLES LIKE 'Reviews'";
            $reviewsTableExists = $this->db->query($checkReviewsTableQuery)->rowCount() > 0;
            
            if (!$reviewsTableExists) {
                // Reviews table doesn't exist, redirect to home
                header('Location: /?msg=review_system_unavailable');
                exit;
            }
            
            // Check if Albums table exists
            $checkAlbumsTableQuery = "SHOW TABLES LIKE 'Albums'";
            $albumsTableExists = $this->db->query($checkAlbumsTableQuery)->rowCount() > 0;
            
            // Get review details with appropriate query based on table existence
            if ($albumsTableExists) {
                $reviewQuery = "SELECT r.*, a.title as album_title, a.image as album_image 
                              FROM Reviews r 
                              LEFT JOIN Albums a ON r.album_id = a.album_id 
                              WHERE r.review_id = ?";
            } else {
                $reviewQuery = "SELECT * FROM Reviews WHERE review_id = ?";
            }
            
            $review = $this->db->query($reviewQuery, [$reviewId])->fetch();
            
            if (!$review) {
                // Review not found, redirect to home page
                header('Location: /');
                exit;
            }
            
            // Check if user is the author of the review
            if ($review['user_id'] != $_SESSION['user_id']) {
                // User is not the author, redirect to reviews page
                header('Location: /album/' . $review['album_id'] . '/reviews?msg=unauthorized');
                exit;
            }
            
            // Prepare album data for the template
            if ($albumsTableExists && isset($review['album_title'])) {
                $album = [
                    'album_id' => $review['album_id'],
                    'title' => $review['album_title'],
                    'image' => $review['album_image'] ?? 'default-album.jpg'
                ];
            } else {
                // Use hardcoded album data
                $album = $this->getHardcodedAlbum($review['album_id']);
            }
            
            return $this->render('review_form.html.twig', [
                'active_page' => 'albums',
                'album' => $album,
                'review' => $review,
                'action' => 'edit'
            ]);
        } catch (\Exception $e) {
            // Log error
            error_log("Database error in editReview: " . $e->getMessage());
            
            // Redirect to home with error message
            header('Location: /?msg=error_editing_review');
            exit;
        }
    }
    
    /**
     * Process review update
     * 
     * @param int $reviewId Review ID
     * @return void
     */
    public function updateReview($reviewId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required');
            exit;
        }
        
        try {
            // Check if Reviews table exists
            $checkReviewsTableQuery = "SHOW TABLES LIKE 'Reviews'";
            $reviewsTableExists = $this->db->query($checkReviewsTableQuery)->rowCount() > 0;
            
            if (!$reviewsTableExists) {
                // Reviews table doesn't exist, redirect to home
                header('Location: /?msg=review_system_unavailable');
                exit;
            }
            
            // Get review details
            $reviewQuery = "SELECT * FROM Reviews WHERE review_id = ?";
            $review = $this->db->query($reviewQuery, [$reviewId])->fetch();
            
            if (!$review) {
                // Review not found, redirect to home page
                header('Location: /');
                exit;
            }
            
            // Check if user is the author of the review
            if ($review['user_id'] != $_SESSION['user_id']) {
                // User is not the author, redirect to reviews page
                header('Location: /album/' . $review['album_id'] . '/reviews?msg=unauthorized');
                exit;
            }
            
            // Get form data
            $rating = isset($_POST['rating']) ? (float)$_POST['rating'] : 0;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            
            // Validate input
            $errors = [];
            
            if ($rating < 0.5 || $rating > 5) {
                $errors['rating'] = 'Rating must be between 0.5 and 5';
            }
            
            if (empty($title)) {
                $errors['title'] = 'Title is required';
            } elseif (strlen($title) > 100) {
                $errors['title'] = 'Title must be less than 100 characters';
            }
            
            if (empty($content)) {
                $errors['content'] = 'Review content is required';
            }
            
            // Get album data for the form (fallback to hardcoded if needed)
            try {
                // Check if Albums table exists
                $checkAlbumsTableQuery = "SHOW TABLES LIKE 'Albums'";
                $albumsTableExists = $this->db->query($checkAlbumsTableQuery)->rowCount() > 0;
                
                if ($albumsTableExists) {
                    $albumQuery = "SELECT * FROM Albums WHERE album_id = ?";
                    $album = $this->db->query($albumQuery, [$review['album_id']])->fetch();
                    
                    if (!$album) {
                        $album = $this->getHardcodedAlbum($review['album_id']);
                    }
                } else {
                    $album = $this->getHardcodedAlbum($review['album_id']);
                }
            } catch (\Exception $e) {
                error_log("Error getting album in updateReview: " . $e->getMessage());
                $album = $this->getHardcodedAlbum($review['album_id']);
            }
            
            // If there are errors, return to the form with error messages
            if (!empty($errors)) {
                return $this->render('review_form.html.twig', [
                    'active_page' => 'albums',
                    'album' => $album,
                    'review' => $review,
                    'action' => 'edit',
                    'errors' => $errors,
                    'input' => [
                        'rating' => $rating,
                        'title' => $title,
                        'content' => $content
                    ]
                ]);
            }
            
            // Update the review in the database
            $updateQuery = "UPDATE Reviews SET rating = ?, title = ?, content = ?, updated_at = ? WHERE review_id = ?";
            $this->db->query($updateQuery, [
                $rating, $title, $content, date('Y-m-d H:i:s'), $reviewId
            ]);
            
            // Redirect to album reviews page with success message
            header('Location: /album/' . $review['album_id'] . '/reviews?msg=review_updated');
            exit;
        } catch (\Exception $e) {
            // Log error
            error_log("Error in updateReview: " . $e->getMessage());
            
            // Redirect with error message
            if (isset($review) && isset($review['album_id'])) {
                header('Location: /album/' . $review['album_id'] . '/reviews?msg=error_updating');
            } else {
                header('Location: /?msg=error_updating_review');
            }
            exit;
        }
    }
    
    /**
     * Delete a review
     * 
     * @param int $reviewId Review ID
     * @return void
     */
    public function deleteReview($reviewId) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required');
            exit;
        }
        
        // Get review details
        $reviewQuery = "SELECT * FROM Reviews WHERE review_id = ?";
        $review = $this->db->query($reviewQuery, [$reviewId])->fetch();
        
        if (!$review) {
            // Review not found, redirect to home page
            header('Location: /');
            exit;
        }
        
        // Check if user is the author of the review or an admin
        if ($review['user_id'] != $_SESSION['user_id'] && (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1)) {
            // User is not authorized, redirect to reviews page
            header('Location: /album/' . $review['album_id'] . '/reviews?msg=unauthorized');
            exit;
        }
        
        try {
            // Delete the review
            $deleteQuery = "DELETE FROM Reviews WHERE review_id = ?";
            $this->db->query($deleteQuery, [$reviewId]);
            
            // Redirect to album reviews page with success message
            header('Location: /album/' . $review['album_id'] . '/reviews?msg=review_deleted');
            exit;
        } catch (\Exception $e) {
            // Log error
            error_log("Error deleting review: " . $e->getMessage());
            
            // Redirect with error message
            header('Location: /album/' . $review['album_id'] . '/reviews?msg=error_deleting');
            exit;
        }
    }
    
    /**
     * Get hardcoded album data as a fallback
     * 
     * @param int $albumId Album ID
     * @return array Album data
     */
    private function getHardcodedAlbum($albumId) {
        $albums = [
            1 => [
                'album_id' => 1,
                'title' => 'Pixies - Trompe Le Monde',
                'artist_name' => 'Pixies',
                'image' => 'pixies-album.jpg',
                'release_date' => '1991-09-23'
            ],
            2 => [
                'album_id' => 2,
                'title' => 'System of a Down - System of a Down',
                'artist_name' => 'System of a Down',
                'image' => 'system-album.jpg',
                'release_date' => '1998-06-30'
            ],
            3 => [
                'album_id' => 3,
                'title' => "BTS - Love Yourself 結 'Answer'",
                'artist_name' => 'BTS',
                'image' => 'BTS-album.jpg',
                'release_date' => '2018-08-24'
            ],
            4 => [
                'album_id' => 4,
                'title' => 'Kendrick Lamar - To Pimp a Butterfly',
                'artist_name' => 'Kendrick Lamar',
                'image' => 'kendrick-album.jpg',
                'release_date' => '2015-03-15'
            ]
        ];
        
        // Return the requested album or a default one if not found
        return isset($albums[$albumId]) ? $albums[$albumId] : $albums[1];
    }
}
