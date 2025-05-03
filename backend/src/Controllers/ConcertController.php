<?php

namespace App\Controllers;

use App\Controller;
use App\Database;

class ConcertController extends Controller {
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
            header('Location: /login?msg=auth_required&redirect=concerts');
            exit;
        }
        
        // Sample concert data (in a real app, this would come from the database)
        $concerts = [
            [
                'id' => 1,
                'artist' => 'Pixies',
                'venue' => 'Madison Square Garden, New York',
                'date' => '2025-05-15',
                'time' => '20:00',
                'price' => 75.00,
                'image' => '/assets/images/pixies-album.jpg',
                'tickets_available' => 150
            ],
            [
                'id' => 2,
                'artist' => 'System of a Down',
                'venue' => 'O2 Arena, London',
                'date' => '2025-06-22',
                'time' => '19:30',
                'price' => 85.00,
                'image' => '/assets/images/system-album.jpg',
                'tickets_available' => 200
            ],
            [
                'id' => 3,
                'artist' => 'BTS',
                'venue' => 'Staples Center, Los Angeles',
                'date' => '2025-07-10',
                'time' => '19:00',
                'price' => 120.00,
                'image' => '/assets/images/BTS-album.jpg',
                'tickets_available' => 100
            ],
            [
                'id' => 4,
                'artist' => 'Kendrick Lamar',
                'venue' => 'Wembley Stadium, London',
                'date' => '2025-08-05',
                'time' => '20:30',
                'price' => 95.00,
                'image' => '/assets/images/kendrick-album.jpg',
                'tickets_available' => 250
            ]
        ];
        
        return $this->render('concerts.html.twig', [
            'active_page' => 'concerts',
            'concerts' => $concerts
        ]);
    }
    
    public function buyTicket($concertId) {
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
        
        // Sample concert data (in a real app, this would come from the database)
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
        
        // Clear the cart first for a direct purchase
        $_SESSION['cart'] = [];
        $_SESSION['cart_count'] = 0;
        
        // Add the concert to the cart
        $item = [
            'id' => $concert['id'],
            'name' => $concert['artist'] . ' - Concert Ticket',
            'price' => $concert['price'],
            'quantity' => 1,
            'image' => $concert['image'],
            'type' => 'concert',
            'details' => [
                'venue' => $concert['venue'],
                'date' => $concert['date'],
                'time' => $concert['time']
            ]
        ];
        
        // Add to cart
        $_SESSION['cart'][$concert['id']] = $item;
        $_SESSION['cart_count'] = 1;
        
        // Redirect to checkout page
        header('Location: /checkout');
        exit;
    }
}
