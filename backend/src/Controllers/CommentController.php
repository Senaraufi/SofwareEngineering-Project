<?php

namespace App\Controllers;

use App\Controller;

class CommentController extends Controller {
    // Sample album data (in a real app, this would come from a database)
    private $albums = [
        1 => [
            'id' => 1,
            'title' => 'Trompe Le Monde',
            'artist' => 'Pixies',
            'genre' => 'Alternative Rock',
            'release_year' => '1991',
            'description' => 'Released September 23, 1991, Trompe Le Monde is the fourth studio album by the American alternative rock band Pixies.',
            'image' => 'pixies-album.jpg',
            'rating' => 4
        ],
        2 => [
            'id' => 2,
            'title' => 'System of a Down',
            'artist' => 'System of a Down',
            'genre' => 'Metal',
            'release_year' => '1998',
            'description' => 'Released June 30, 1998, System of a Down is the debut studio album by American heavy metal band System of a Down.',
            'image' => 'system-album.jpg',
            'rating' => 5
        ],
        3 => [
            'id' => 3,
            'title' => "Love Yourself 結 'Answer'",
            'artist' => 'BTS',
            'genre' => 'K-Pop',
            'release_year' => '2018',
            'description' => "Released August 24, 2018, Love Yourself 結 'Answer' is a compilation album by South Korean boy band BTS.",
            'image' => 'BTS-album.jpg',
            'rating' => 4
        ],
        4 => [
            'id' => 4,
            'title' => 'To Pimp a Butterfly',
            'artist' => 'Kendrick Lamar',
            'genre' => 'Hip Hop',
            'release_year' => '2015',
            'description' => 'Released March 15, 2015, To Pimp a Butterfly is the third studio album by American rapper Kendrick Lamar.',
            'image' => 'kendrick-album.jpg',
            'rating' => 5
        ],
        5 => [
            'id' => 5,
            'title' => 'Random Access Memories',
            'artist' => 'Daft Punk',
            'genre' => 'Electronic',
            'release_year' => '2013',
            'description' => 'Released May 17, 2013, Random Access Memories is the fourth studio album by French electronic music duo Daft Punk.',
            'image' => 'daftpunk-album.jpg',
            'rating' => 4
        ],
        6 => [
            'id' => 6,
            'title' => 'OK Computer',
            'artist' => 'Radiohead',
            'genre' => 'Alternative Rock',
            'release_year' => '1997',
            'description' => 'Released May 21, 1997, OK Computer is the third studio album by English rock band Radiohead.',
            'image' => 'radiohead-album.jpg',
            'rating' => 5
        ],
        7 => [
            'id' => 7,
            'title' => 'Lemonade',
            'artist' => 'Beyoncé',
            'genre' => 'R&B',
            'release_year' => '2016',
            'description' => 'Released April 23, 2016, Lemonade is the sixth studio album by American singer Beyoncé.',
            'image' => 'beyonce-album.jpg',
            'rating' => 5
        ],
        8 => [
            'id' => 8,
            'title' => 'Abbey Road',
            'artist' => 'The Beatles',
            'genre' => 'Rock',
            'release_year' => '1969',
            'description' => 'Released September 26, 1969, Abbey Road is the eleventh studio album by English rock band the Beatles.',
            'image' => 'beatles-album.jpg',
            'rating' => 5
        ],
        9 => [
            'id' => 9,
            'title' => 'Nevermind',
            'artist' => 'Nirvana',
            'genre' => 'Grunge',
            'release_year' => '1991',
            'description' => 'Released September 24, 1991, Nevermind is the second studio album by American rock band Nirvana.',
            'image' => 'nirvana-album.jpg',
            'rating' => 5
        ],
        10 => [
            'id' => 10,
            'title' => 'Rumours',
            'artist' => 'Fleetwood Mac',
            'genre' => 'Rock',
            'release_year' => '1977',
            'description' => 'Released February 4, 1977, Rumours is the eleventh studio album by British-American rock band Fleetwood Mac.',
            'image' => 'fleetwood-album.jpg',
            'rating' => 4
        ],
        11 => [
            'id' => 11,
            'title' => '1989',
            'artist' => 'Taylor Swift',
            'genre' => 'Pop',
            'release_year' => '2014',
            'description' => 'Released October 27, 2014, 1989 is the fifth studio album by American singer-songwriter Taylor Swift.',
            'image' => 'taylor-album.jpg',
            'rating' => 4
        ],
        12 => [
            'id' => 12,
            'title' => 'Dark Side of the Moon',
            'artist' => 'Pink Floyd',
            'genre' => 'Progressive Rock',
            'release_year' => '1973',
            'description' => 'Released March 1, 1973, The Dark Side of the Moon is the eighth studio album by English rock band Pink Floyd.',
            'image' => 'pinkfloyd-album.jpg',
            'rating' => 5
        ]
    ];
    
    // Sample artist data (in a real app, this would come from a database)
    private $artists = [
        1 => [
            'id' => 1,
            'name' => 'Pixies',
            'image' => 'pixies-artist.jpg',
            'description' => 'The Pixies are an American alternative rock band formed in 1986. They have been a major influence on many artists and helped pioneer the loud-quiet dynamic that would become a cornerstone of alternative rock.',
            'genres' => ['Alternative Rock', 'Indie Rock'],
            'rating' => 5
        ],
        2 => [
            'id' => 2,
            'name' => 'System of a Down',
            'image' => 'system-artist.jpg',
            'description' => 'System of a Down is an Armenian-American heavy metal band formed in 1994. The band achieved commercial success with the release of five studio albums.',
            'genres' => ['Metal', 'Alternative Metal'],
            'rating' => 4
        ],
        3 => [
            'id' => 3,
            'name' => 'BTS',
            'image' => 'bts-artist.jpg',
            'description' => 'BTS, also known as the Bangtan Boys, is a seven-member South Korean boy band formed in 2010. The band has achieved global recognition and is known for their impact on youth culture.',
            'genres' => ['K-Pop', 'Pop'],
            'rating' => 5
        ],
        4 => [
            'id' => 4,
            'name' => 'Kendrick Lamar',
            'image' => 'kendrick-artist.jpg',
            'description' => 'Kendrick Lamar is an American rapper and songwriter. His critically acclaimed albums have made him one of the most influential artists of his generation.',
            'genres' => ['Hip Hop', 'Rap'],
            'rating' => 5
        ]
    ];
    
    /**
     * Show comments for an album
     */
    public function showAlbumComments($id = 1) {
        $albumId = $id; // Map the named parameter to our variable
        // Get album data
        $album = $this->getAlbumById($albumId);
        
        if (!$album) {
            // If album not found, redirect to albums page
            header('Location: /albums');
            exit;
        }
        
        // Get comments for this album
        $comments = $this->getCommentsForItem('album', $albumId);
        $children = $this->buildCommentTree($comments);
        
        return $this->render('comment.html.twig', [
            'type' => 'album',
            'item' => $album,
            'comments' => $comments,
            'children' => $children,
            'active_page' => 'comments'
        ]);
    }
    
    /**
     * Show comments for an artist
     */
    public function showArtistComments($id = 1) {
        $artistId = $id; // Map the named parameter to our variable
        // Get artist data
        $artist = $this->getArtistById($artistId);
        
        if (!$artist) {
            // If artist not found, redirect to artists page
            header('Location: /artists');
            exit;
        }
        
        // Get comments for this artist
        $comments = $this->getCommentsForItem('artist', $artistId);
        $children = $this->buildCommentTree($comments);
        
        return $this->render('comment.html.twig', [
            'type' => 'artist',
            'item' => $artist,
            'comments' => $comments,
            'children' => $children,
            'active_page' => 'comments'
        ]);
    }
    
    /**
     * Add a new comment
     */
    public function addComment() {
        // Get data from POST
        $type = $_POST['type'] ?? 'album'; // 'album' or 'artist'
        $itemId = $_POST['item_id'] ?? 1;
        $content = $_POST['content'] ?? '';
        
        // In a real implementation, this would save to database
        // For now, just redirect back to comments page
        if ($type === 'album') {
            header('Location: /album/' . $itemId . '/comments');
        } else {
            header('Location: /artist/' . $itemId . '/comments');
        }
        exit;
    }
    
    /**
     * Reply to an existing comment
     */
    public function replyToComment() {
        // Get data from POST
        $type = $_POST['type'] ?? 'album'; // 'album' or 'artist'
        $itemId = $_POST['item_id'] ?? 1;
        $parentId = $_POST['parent_id'] ?? 0;
        $content = $_POST['content'] ?? '';
        
        // In a real implementation, this would save to database
        // For now, just redirect back to comments page
        if ($type === 'album') {
            header('Location: /album/' . $itemId . '/comments');
        } else {
            header('Location: /artist/' . $itemId . '/comments');
        }
        exit;
    }
    
    /**
     * Get album by ID
     */
    private function getAlbumById($id) {
        return $this->albums[$id] ?? null;
    }
    
    /**
     * Get artist by ID
     */
    private function getArtistById($id) {
        return $this->artists[$id] ?? null;
    }
    
    /**
     * Get comments for a specific item (album or artist)
     */
    private function getCommentsForItem($type, $itemId) {
        // In a real implementation, this would fetch from database
        // For now, return dummy data
        return [
            ['id' => 1, 'parent_id' => 0, 'user' => 'Alice', 'content' => 'Great ' . $type . '!', 'created_at' => '2025-04-19 19:00'],
            ['id' => 2, 'parent_id' => 1, 'user' => 'Bob', 'content' => 'I agree!', 'created_at' => '2025-04-19 19:05'],
            ['id' => 3, 'parent_id' => 1, 'user' => 'Charlie', 'content' => 'Not my style, but respect.', 'created_at' => '2025-04-19 19:10'],
            ['id' => 4, 'parent_id' => 2, 'user' => 'Diana', 'content' => 'Same here!', 'created_at' => '2025-04-19 19:15'],
            ['id' => 5, 'parent_id' => 0, 'user' => 'Eve', 'content' => 'I love this ' . $type . '!', 'created_at' => '2025-04-19 19:20'],
        ];
    }
    
    /**
     * Build a comment tree from flat comments array
     */
    private function buildCommentTree($comments) {
        $children = [];
        foreach ($comments as $comment) {
            $parentId = $comment['parent_id'] ?? 0;
            if (!isset($children[$parentId])) {
                $children[$parentId] = [];
            }
            $children[$parentId][] = $comment;
        }
        return $children;
    }
}
