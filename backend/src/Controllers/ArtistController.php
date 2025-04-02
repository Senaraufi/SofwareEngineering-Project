<?php

namespace App\Controllers;

use App\Controller;
use App\Database;
use App\Models\Artist;
use App\Models\Album;

class ArtistController extends Controller {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index() {
        // Hardcoded artist data (in real implementation, this would come from database)
        $artists = [
            1 => [
                'artist_id' => 1,
                'name' => 'Pixies',
                'image_url' => '/assets/images/pixies-album.jpg',
                'description' => 'The Pixies are an American alternative rock band formed in 1986.',
                'genres' => ['Alternative Rock', 'Indie Rock']
            ],
            2 => [
                'artist_id' => 2,
                'name' => 'System of a Down',
                'image_url' => '/assets/images/system-album.jpg',
                'description' => 'System of a Down is an Armenian-American heavy metal band formed in 1994.',
                'genres' => ['Metal', 'Alternative Metal']
            ],
            3 => [
                'artist_id' => 3,
                'name' => 'BTS',
                'image_url' => '/assets/images/BTS-album.jpg',
                'description' => 'BTS is a South Korean boy band formed in 2010.',
                'genres' => ['K-Pop', 'Pop']
            ],
            4 => [
                'artist_id' => 4,
                'name' => 'Kendrick Lamar',
                'image_url' => '/assets/images/kendrick-album.jpg',
                'description' => 'Kendrick Lamar is an American rapper and songwriter.',
                'genres' => ['Hip Hop', 'Rap']
            ]
        ];

        $artistObjects = array_map(function($artistData) {
            return new Artist($artistData);
        }, $artists);

        return $this->render('artists.html.twig', [
            'artists' => $artistObjects,
            'active_page' => 'artists'
        ]);
    }
    
    public function show($artistId) {
        // Hardcoded artist data (in real implementation, this would come from database)
        $artists = [
            1 => [
                'artist_id' => 1,
                'name' => 'Pixies',
                'image_url' => '/assets/images/pixies-album.jpg',
                'description' => 'The Pixies are an American alternative rock band formed in 1986. They have been a major influence on many artists and helped pioneer the loud-quiet dynamic that would become a cornerstone of alternative rock.',
                'genres' => ['Alternative Rock', 'Indie Rock']
            ],
            2 => [
                'artist_id' => 2,
                'name' => 'System of a Down',
                'image_url' => '/assets/images/system-album.jpg',
                'description' => 'System of a Down is an Armenian-American heavy metal band formed in 1994. Known for their unique sound combining heavy metal with unconventional song structures, progressive rock, and Armenian folk music.',
                'genres' => ['Metal', 'Alternative Metal']
            ],
            3 => [
                'artist_id' => 3,
                'name' => 'BTS',
                'image_url' => '/assets/images/BTS-album.jpg',
                'description' => 'BTS is a South Korean boy band formed in 2010. The band has become a global phenomenon, breaking numerous records and helping to bring K-pop music to international audiences.',
                'genres' => ['K-Pop', 'Pop']
            ],
            4 => [
                'artist_id' => 4,
                'name' => 'Kendrick Lamar',
                'image_url' => '/assets/images/kendrick-album.jpg',
                'description' => 'Kendrick Lamar is an American rapper, songwriter, and record producer. He is widely regarded as one of the most influential rappers of his generation, known for his progressive musical styles and socially conscious songwriting.',
                'genres' => ['Hip Hop', 'Rap']
            ]
        ];

        if (!isset($artists[$artistId])) {
            header('Location: /browse');
            exit;
        }

        $artistData = $artists[$artistId];
        $artist = new Artist($artistData);

        // Get albums for this artist (reusing album data from PageController)
        $allAlbums = [
            1 => [
                'id' => 1,
                'title' => 'Trompe Le Monde',
                'artist_id' => 1,
                'genre' => 'Alternative Rock',
                'release_date' => '1991-09-23',
                'image_url' => '/assets/images/albums/pixies-album.jpg',
                'description' => 'The fourth studio album by the Pixies.'
            ],
            2 => [
                'id' => 2,
                'title' => 'Toxicity',
                'artist_id' => 2,
                'genre' => 'Metal',
                'release_date' => '2001-09-04',
                'image_url' => '/assets/images/albums/system-album.jpg',
                'description' => 'The second studio album by System of a Down.'
            ],
            3 => [
                'id' => 3,
                'title' => "Love Yourself 結 'Answer'",
                'artist_id' => 3,
                'genre' => 'K-Pop',
                'release_date' => '2018-08-24',
                'image_url' => '/assets/images/albums/BTS-album.jpg',
                'description' => 'A compilation album by BTS.'
            ],
            4 => [
                'id' => 4,
                'title' => 'To Pimp a Butterfly',
                'artist_id' => 4,
                'genre' => 'Hip Hop',
                'release_date' => '2015-03-15',
                'image_url' => '/assets/images/albums/kendrick-album.jpg',
                'description' => 'The third studio album by Kendrick Lamar.'
            ]
        ];

        $albums = array_filter($allAlbums, function($album) use ($artistId) {
            return $album['artist_id'] == $artistId;
        });

        $albums = array_map(function($album) {
            return new Album($album);
        }, $albums);
        
        return $this->render('artist.html.twig', [
            'artist' => $artist,
            'albums' => $albums,
            'active_page' => 'browse'
        ]);
    }
}
