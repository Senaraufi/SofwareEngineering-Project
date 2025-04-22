<?php

namespace App\Controllers;

use App\Controller;
use App\Database;

class CartController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=cart');
            exit;
        }
        
        // Get cart items from session
        $cartItems = $_SESSION['cart'] ?? [];
        $totalPrice = 0;
        
        // Calculate total price
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        
        return $this->render('cart.html.twig', [
            'active_page' => 'cart',
            'cart_items' => $cartItems,
            'total_price' => $totalPrice
        ]);
    }
    
    public function addToCart() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=concerts');
            exit;
        }
        
        // Get item details from POST
        $concertId = $_POST['concert_id'] ?? null;
        $type = $_POST['type'] ?? 'concert';
        
        if (!$concertId) {
            // Redirect back if no concert ID
            header('Location: /concerts');
            exit;
        }
        
        // Get concert details (in a real app, this would come from the database)
        $concerts = [
            1 => [
                'id' => 1,
                'artist' => 'Pixies',
                'venue' => 'Madison Square Garden, New York',
                'date' => '2025-05-15',
                'time' => '20:00',
                'price' => 75.00,
                'image' => '/assets/images/pixies-album.jpg'
            ],
            2 => [
                'id' => 2,
                'artist' => 'System of a Down',
                'venue' => 'O2 Arena, London',
                'date' => '2025-06-22',
                'time' => '19:30',
                'price' => 85.00,
                'image' => '/assets/images/system-album.jpg'
            ],
            3 => [
                'id' => 3,
                'artist' => 'BTS',
                'venue' => 'Staples Center, Los Angeles',
                'date' => '2025-07-10',
                'time' => '19:00',
                'price' => 120.00,
                'image' => '/assets/images/BTS-album.jpg'
            ],
            4 => [
                'id' => 4,
                'artist' => 'Kendrick Lamar',
                'venue' => 'Wembley Stadium, London',
                'date' => '2025-08-05',
                'time' => '20:30',
                'price' => 95.00,
                'image' => '/assets/images/kendrick-album.jpg'
            ]
        ];
        
        // Check if concert exists
        if (!isset($concerts[$concertId])) {
            header('Location: /concerts');
            exit;
        }
        
        $concert = $concerts[$concertId];
        
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Create a unique cart item ID
        $cartItemId = 'concert_' . $concertId;
        
        // Check if item already exists in cart
        if (isset($_SESSION['cart'][$cartItemId])) {
            // Increment quantity
            $_SESSION['cart'][$cartItemId]['quantity']++;
        } else {
            // Add new item to cart
            $_SESSION['cart'][$cartItemId] = [
                'id' => $cartItemId,
                'type' => $type,
                'concert_id' => $concertId,
                'artist' => $concert['artist'],
                'venue' => $concert['venue'],
                'date' => $concert['date'],
                'time' => $concert['time'],
                'price' => $concert['price'],
                'image' => $concert['image'],
                'quantity' => 1
            ];
        }
        
        // Update cart count in session
        $cartCount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
        }
        $_SESSION['cart_count'] = $cartCount;
        
        // Redirect to cart page
        header('Location: /cart');
        exit;
    }
    
    public function removeFromCart() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=cart');
            exit;
        }
        
        // Get item ID from POST
        $itemId = $_POST['item_id'] ?? null;
        
        if (!$itemId || !isset($_SESSION['cart'][$itemId])) {
            // Redirect back if no item ID or item doesn't exist
            header('Location: /cart');
            exit;
        }
        
        // Remove item from cart
        unset($_SESSION['cart'][$itemId]);
        
        // Update cart count in session
        $cartCount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
        }
        $_SESSION['cart_count'] = $cartCount;
        
        // Redirect to cart page
        header('Location: /cart');
        exit;
    }
    
    public function updateQuantity() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=cart');
            exit;
        }
        
        // Get item details from POST
        $itemId = $_POST['item_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (!$itemId || !isset($_SESSION['cart'][$itemId])) {
            // Redirect back if no item ID or item doesn't exist
            header('Location: /cart');
            exit;
        }
        
        // Ensure quantity is at least 1
        $quantity = max(1, $quantity);
        
        // Update quantity
        $_SESSION['cart'][$itemId]['quantity'] = $quantity;
        
        // Update cart count in session
        $cartCount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['quantity'];
        }
        $_SESSION['cart_count'] = $cartCount;
        
        // Redirect to cart page
        header('Location: /cart');
        exit;
    }
    
    public function checkout() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['Active']) || $_SESSION['Active'] !== true) {
            // Redirect to login page with a message
            header('Location: /login?msg=auth_required&redirect=cart');
            exit;
        }
        
        // Get cart items from session
        $cartItems = $_SESSION['cart'] ?? [];
        
        if (empty($cartItems)) {
            // Redirect to cart page if cart is empty
            header('Location: /cart');
            exit;
        }
        
        // Process checkout (in a real app, this would save to database)
        $orderId = 'TT-' . time() . '-' . rand(1000, 9999);
        $purchaseDate = date('Y-m-d H:i:s');
        
        // Clear cart
        $_SESSION['cart'] = [];
        $_SESSION['cart_count'] = 0;
        
        // Redirect to order confirmation page
        header('Location: /order/confirmation/' . $orderId);
        exit;
    }
}
