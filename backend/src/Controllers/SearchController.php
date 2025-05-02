<?php
/**
 * Search Controller
 * 
 * References:
 * - Search implementation inspired by Laravel's Eloquent search: https://laravel.com/docs/8.x/eloquent#searching
 * - Error handling approach based on robust error handling patterns as implemented in Database.php
 */

namespace App\Controllers;

use App\Controller;
use App\Database;
use App\Models\Artist;
use App\Models\Concert;
use App\Models\Album;

class SearchController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Handle global search across the site
     * 
     * @return string Rendered template with search results
     */
    public function search() {
        $query = $_GET['q'] ?? '';
        $query = trim($query);
        
        if (empty($query)) {
            return $this->render('search_results.html.twig', [
                'active_page' => 'search',
                'query' => '',
                'artists' => [],
                'albums' => [],
                'concerts' => []
            ]);
        }
        
        try {
            // Search for artists
            $artists = $this->searchArtists($query);
            
            // Search for albums
            $albums = $this->searchAlbums($query);
            
            // Search for concerts
            $concerts = $this->searchConcerts($query);
            
            return $this->render('search_results.html.twig', [
                'active_page' => 'search',
                'query' => $query,
                'artists' => $artists,
                'albums' => $albums,
                'concerts' => $concerts
            ]);
        } catch (\Exception $e) {
            // Log the error but show a user-friendly message
            error_log("Search error: " . $e->getMessage());
            return $this->render('search_results.html.twig', [
                'active_page' => 'search',
                'query' => $query,
                'error' => 'An error occurred while searching. Please try again later.',
                'artists' => [],
                'albums' => [],
                'concerts' => []
            ]);
        }
    }
    
    /**
     * Search for artists matching the query
     * 
     * @param string $query Search query
     * @return array Array of matching artists
     */
    private function searchArtists($query) {
        // In a real implementation, this would query the database
        // For now, we'll use hardcoded data similar to PageController
        $allArtists = [
            [
                'artist_id' => 1,
                'name' => 'Pixies',
                'image_url' => 'pixies-artist.jpg',
                'genres' => ['Alternative Rock', 'Indie Rock'],
                'description' => 'American alternative rock band formed in 1986'
            ],
            [
                'artist_id' => 2,
                'name' => 'System of a Down',
                'image_url' => 'system-artist.jpg',
                'genres' => ['Metal', 'Alternative Metal'],
                'description' => 'Armenian-American heavy metal band formed in 1994'
            ],
            [
                'artist_id' => 3,
                'name' => 'BTS',
                'image_url' => 'bts-artist.jpg',
                'genres' => ['K-Pop', 'Pop'],
                'description' => 'South Korean boy band formed in 2013'
            ],
            [
                'artist_id' => 4,
                'name' => 'Kendrick Lamar',
                'image_url' => 'kendrick-artist.jpg',
                'genres' => ['Hip Hop', 'Rap'],
                'description' => 'American rapper and songwriter'
            ],
            [
                'artist_id' => 5,
                'name' => 'Taylor Swift',
                'image_url' => 'taylorswift-artist.jpg',
                'genres' => ['Pop', 'Country'],
                'description' => 'American singer-songwriter'
            ],
            [
                'artist_id' => 6,
                'name' => 'Radiohead',
                'image_url' => 'radiohead-artist.jpeg',
                'genres' => ['Alternative Rock', 'Experimental'],
                'description' => 'English rock band formed in 1985'
            ]
        ];
        
        $query = strtolower($query);
        return array_filter($allArtists, function($artist) use ($query) {
            return strpos(strtolower($artist['name']), $query) !== false ||
                   strpos(strtolower($artist['description']), $query) !== false ||
                   count(array_filter($artist['genres'], function($genre) use ($query) {
                       return strpos(strtolower($genre), $query) !== false;
                   })) > 0;
        });
    }
    
    /**
     * Search for albums matching the query
     * 
     * @param string $query Search query
     * @return array Array of matching albums
     */
    private function searchAlbums($query) {
        // In a real implementation, this would query the database
        $allAlbums = [
            [
                'id' => 1,
                'title' => 'Trompe Le Monde',
                'artist' => 'Pixies',
                'genre' => 'Alternative Rock',
                'release' => 'September 23, 1991',
                'image' => 'pixies-album.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Toxicity',
                'artist' => 'System of a Down',
                'genre' => 'Metal',
                'release' => 'September 4, 2001',
                'image' => 'system-album.jpg'
            ],
            [
                'id' => 3,
                'title' => 'Map of the Soul: 7',
                'artist' => 'BTS',
                'genre' => 'K-Pop',
                'release' => 'February 21, 2020',
                'image' => 'bts-album.jpg'
            ],
            [
                'id' => 4,
                'title' => 'To Pimp a Butterfly',
                'artist' => 'Kendrick Lamar',
                'genre' => 'Hip Hop',
                'release' => 'March 15, 2015',
                'image' => 'kendrick-album.jpg'
            ],
            [
                'id' => 5,
                'title' => '1989',
                'artist' => 'Taylor Swift',
                'genre' => 'Pop',
                'release' => 'October 27, 2014',
                'image' => 'taylor-album.jpg'
            ],
            [
                'id' => 6,
                'title' => 'OK Computer',
                'artist' => 'Radiohead',
                'genre' => 'Alternative Rock',
                'release' => 'May 21, 1997',
                'image' => 'radiohead-album.jpg'
            ]
        ];
        
        $query = strtolower($query);
        return array_filter($allAlbums, function($album) use ($query) {
            return strpos(strtolower($album['title']), $query) !== false ||
                   strpos(strtolower($album['artist']), $query) !== false ||
                   strpos(strtolower($album['genre']), $query) !== false;
        });
    }
    
    /**
     * Search for concerts matching the query
     * 
     * @param string $query Search query
     * @return array Array of matching concerts
     */
    private function searchConcerts($query) {
        // In a real implementation, this would query the database
        $allConcerts = [
            [
                'id' => 1,
                'artist' => 'Pixies',
                'venue' => 'Madison Square Garden, New York',
                'date' => '2025-05-15',
                'time' => '20:00',
                'price' => 75.00,
                'image' => 'pixies-album.jpg'
            ],
            [
                'id' => 2,
                'artist' => 'System of a Down',
                'venue' => 'O2 Arena, London',
                'date' => '2025-06-22',
                'time' => '19:30',
                'price' => 85.00,
                'image' => 'system-album.jpg'
            ],
            [
                'id' => 3,
                'artist' => 'BTS',
                'venue' => 'Staples Center, Los Angeles',
                'date' => '2025-07-10',
                'time' => '19:00',
                'price' => 120.00,
                'image' => 'bts-album.jpg'
            ],
            [
                'id' => 4,
                'artist' => 'Kendrick Lamar',
                'venue' => 'Wembley Stadium, London',
                'date' => '2025-08-05',
                'time' => '20:30',
                'price' => 95.00,
                'image' => 'kendrick-album.jpg'
            ],
            [
                'id' => 5,
                'artist' => 'Taylor Swift',
                'venue' => 'Rose Bowl, Pasadena',
                'date' => '2025-09-12',
                'time' => '19:30',
                'price' => 150.00,
                'image' => 'taylor-album.jpg'
            ],
            [
                'id' => 6,
                'artist' => 'Radiohead',
                'venue' => 'Sydney Opera House, Sydney',
                'date' => '2025-10-18',
                'time' => '20:00',
                'price' => 110.00,
                'image' => 'radiohead-album.jpg'
            ]
        ];
        
        $query = strtolower($query);
        return array_filter($allConcerts, function($concert) use ($query) {
            return strpos(strtolower($concert['artist']), $query) !== false ||
                   strpos(strtolower($concert['venue']), $query) !== false;
        });
    }
    
    /**
     * API endpoint for search suggestions (for autocomplete)
     * 
     * @return string JSON response with search suggestions
     */
    public function searchSuggestions() {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        $query = trim($query);
        
        if (empty($query)) {
            echo json_encode(['suggestions' => []]);
            return;
        }
        
        try {
            $artists = $this->searchArtists($query);
            $albums = $this->searchAlbums($query);
            $concerts = $this->searchConcerts($query);
            
            $suggestions = [];
            
            // Add artist suggestions
            foreach ($artists as $artist) {
                $suggestions[] = [
                    'type' => 'artist',
                    'text' => $artist['name'],
                    'url' => '/artists/' . $artist['artist_id']
                ];
            }
            
            // Add album suggestions
            foreach ($albums as $album) {
                $suggestions[] = [
                    'type' => 'album',
                    'text' => $album['title'] . ' by ' . $album['artist'],
                    'url' => '/albums/' . $album['id']
                ];
            }
            
            // Add concert suggestions
            foreach ($concerts as $concert) {
                $suggestions[] = [
                    'type' => 'concert',
                    'text' => $concert['artist'] . ' at ' . $concert['venue'],
                    'url' => '/concerts/' . $concert['id']
                ];
            }
            
            // Limit to 10 suggestions
            $suggestions = array_slice($suggestions, 0, 10);
            
            echo json_encode(['suggestions' => $suggestions]);
        } catch (\Exception $e) {
            // Return empty suggestions on error
            echo json_encode(['suggestions' => [], 'error' => 'An error occurred']);
        }
    }
}
