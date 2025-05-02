<?php
/**
 * Cart Controller
 * 
 * References:
 * - Shopping cart implementation based on session handling techniques from PHP documentation: https://www.php.net/manual/en/book.session.php
 * - Currency conversion implementation inspired by Money PHP library: https://github.com/moneyphp/money
 * - Session management security follows the robust error handling and security patterns implemented in UserController.php
 */

namespace App\Controllers;

use App\Controller;
use App\Database;
use App\Services\CurrencyService;

class CartController extends Controller {
    private $db;
    private $currencyService;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->currencyService = new CurrencyService();
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
        
        // Get selected currency (default to USD if not set)
        $currency = $_SESSION['currency'] ?? 'USD';
        
        // Calculate total price
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        
        // Get available currencies for the dropdown
        $availableCurrencies = $this->currencyService->getAvailableCurrencies();
        
        // Convert total price to selected currency
        $convertedTotalPrice = $this->currencyService->convert($totalPrice, $currency);
        
        // Format prices for each item in the selected currency
        $formattedCartItems = [];
        foreach ($cartItems as $id => $item) {
            $convertedPrice = $this->currencyService->convert($item['price'], $currency);
            $item['formatted_price'] = $this->currencyService->format($convertedPrice, $currency);
            $item['subtotal'] = $convertedPrice * $item['quantity'];
            $item['formatted_subtotal'] = $this->currencyService->format($item['subtotal'], $currency);
            $formattedCartItems[$id] = $item;
        }
        
        return $this->render('cart.html.twig', [
            'active_page' => 'cart',
            'cart_items' => $formattedCartItems,
            'total_price' => $convertedTotalPrice,
            'formatted_total' => $this->currencyService->format($convertedTotalPrice, $currency),
            'currency' => $currency,
            'available_currencies' => $availableCurrencies,
            'currency_symbol' => $this->currencyService->getSymbol($currency)
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
    
    /**
     * Set the currency for the shopping cart
     */
    public function setCurrency() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Get currency from POST
        $currency = $_POST['currency'] ?? 'USD';
        
        // Validate currency
        $availableCurrencies = $this->currencyService->getAvailableCurrencies();
        if (!isset($availableCurrencies[$currency])) {
            $currency = 'USD'; // Default to USD if invalid
        }
        
        // Set currency in session
        $_SESSION['currency'] = $currency;
        
        // Redirect back to cart page
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
        
        // Get selected currency
        $currency = $_SESSION['currency'] ?? 'USD';
        
        // Calculate total in selected currency
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $convertedTotalPrice = $this->currencyService->convert($totalPrice, $currency);
        
        // Process checkout (in a real app, this would save to database)
        $orderId = 'TT-' . time() . '-' . rand(1000, 9999);
        $purchaseDate = date('Y-m-d H:i:s');
        
        // Store order details in session for confirmation page
        $_SESSION['last_order'] = [
            'order_id' => $orderId,
            'purchase_date' => $purchaseDate,
            'items' => $cartItems,
            'total' => $convertedTotalPrice,
            'currency' => $currency,
            'currency_symbol' => $this->currencyService->getSymbol($currency)
        ];
        
        // Clear cart
        $_SESSION['cart'] = [];
        $_SESSION['cart_count'] = 0;
        
        // Redirect to order confirmation page
        header('Location: /order/confirmation/' . $orderId);
        exit;
    }
}
