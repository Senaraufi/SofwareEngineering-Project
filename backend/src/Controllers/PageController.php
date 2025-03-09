<?php

namespace App\Controllers;

use App\Controller;

class PageController extends Controller {
    public function home() {
        return $this->render('home.html.twig', [
            'active_page' => 'home'
        ]);
    }

    public function browse() {
        // Hardcoded album data for display
        // In a real implementation, this would come from the database
        $albums = [
            [
                'id' => 1,
                'title' => 'Pixies - Trompe Le Monde',
                'genre' => 'ALTERNATIVE ROCK',
                'release' => 'Released September 23, 1991',
                'image' => 'pixies-album.jpg',
                'link' => 'https://open.spotify.com/album/1xtaONLuwdb5STNnLGNVGi?si=1SAGEOPLQZuB08YQb-LMiA'
            ],
            [
                'id' => 2,
                'title' => 'System of a Down - Toxicity',
                'genre' => 'METAL',
                'release' => 'Released September 4, 2001',
                'image' => 'system-album.jpg',
                'link' => 'https://open.spotify.com/album/3sSfjX4fhZonjyZ10x0l0f?si=5Xvm2SeeSziv5mEKEQahWg'
            ],
            [
                'id' => 3,
                'title' => "BTS - Love Yourself 結 'Answer'",
                'genre' => 'K-POP',
                'release' => 'Released August 24, 2018',
                'image' => 'BTS-album.jpg',
                'link' => 'https://open.spotify.com/album/43wFM1HquliY3iwKWzPN4y?si=G3ywSgxNSwWRrv-gqDjlHA'
            ],
            [
                'id' => 4,
                'title' => 'Kendrick Lamar - To Pimp a Butterfly',
                'genre' => 'HIP HOP',
                'release' => 'Released March 15, 2015',
                'image' => 'kendrick-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 5,
                'title' => 'Daft Punk - Random Access Memories',
                'genre' => 'ELECTRONIC',
                'release' => 'Released May 17, 2013',
                'image' => 'daftpunk-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 6,
                'title' => 'Radiohead - OK Computer',
                'genre' => 'ALTERNATIVE ROCK',
                'release' => 'Released May 21, 1997',
                'image' => 'radiohead-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 7,
                'title' => 'Beyoncé - Lemonade',
                'genre' => 'R&B',
                'release' => 'Released April 23, 2016',
                'image' => 'beyonce-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 8,
                'title' => 'The Beatles - Abbey Road',
                'genre' => 'ROCK',
                'release' => 'Released September 26, 1969',
                'image' => 'beatles-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 9,
                'title' => 'Nirvana - Nevermind',
                'genre' => 'GRUNGE',
                'release' => 'Released September 24, 1991',
                'image' => 'nirvana-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 10,
                'title' => 'Fleetwood Mac - Rumours',
                'genre' => 'ROCK',
                'release' => 'Released February 4, 1977',
                'image' => 'fleetwood-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 11,
                'title' => 'Taylor Swift - 1989',
                'genre' => 'POP',
                'release' => 'Released October 27, 2014',
                'image' => 'taylor-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 12,
                'title' => 'Pink Floyd - Dark Side of the Moon',
                'genre' => 'PROGRESSIVE ROCK',
                'release' => 'Released March 1, 1973',
                'image' => 'pinkfloyd-album.jpg',
                'link' => '#'
            ]
        ];
        
        return $this->render('browse.html.twig', [
            'active_page' => 'browse',
            'albums' => $albums
        ]);
    }

    public function albums() {
        // Reuse the same album data as in the browse method
        // In a real implementation, this would come from the database
        $albums = [
            [
                'id' => 1,
                'title' => 'Pixies - Trompe Le Monde',
                'genre' => 'ALTERNATIVE ROCK',
                'release' => 'Released September 23, 1991',
                'image' => 'pixies-album.jpg',
                'link' => 'https://open.spotify.com/album/1xtaONLuwdb5STNnLGNVGi?si=1SAGEOPLQZuB08YQb-LMiA'
            ],
            [
                'id' => 2,
                'title' => 'System of a Down - Toxicity',
                'genre' => 'METAL',
                'release' => 'Released September 4, 2001',
                'image' => 'system-album.jpg',
                'link' => 'https://open.spotify.com/album/3sSfjX4fhZonjyZ10x0l0f?si=5Xvm2SeeSziv5mEKEQahWg'
            ],
            [
                'id' => 3,
                'title' => "BTS - Love Yourself 結 'Answer'",
                'genre' => 'K-POP',
                'release' => 'Released August 24, 2018',
                'image' => 'BTS-album.jpg',
                'link' => 'https://open.spotify.com/album/43wFM1HquliY3iwKWzPN4y?si=G3ywSgxNSwWRrv-gqDjlHA'
            ],
            [
                'id' => 4,
                'title' => 'Kendrick Lamar - To Pimp a Butterfly',
                'genre' => 'HIP HOP',
                'release' => 'Released March 15, 2015',
                'image' => 'kendrick-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 5,
                'title' => 'Daft Punk - Random Access Memories',
                'genre' => 'ELECTRONIC',
                'release' => 'Released May 17, 2013',
                'image' => 'daftpunk-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 6,
                'title' => 'Radiohead - OK Computer',
                'genre' => 'ALTERNATIVE ROCK',
                'release' => 'Released May 21, 1997',
                'image' => 'radiohead-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 7,
                'title' => 'Beyoncé - Lemonade',
                'genre' => 'R&B',
                'release' => 'Released April 23, 2016',
                'image' => 'beyonce-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 8,
                'title' => 'The Beatles - Abbey Road',
                'genre' => 'ROCK',
                'release' => 'Released September 26, 1969',
                'image' => 'beatles-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 9,
                'title' => 'Nirvana - Nevermind',
                'genre' => 'GRUNGE',
                'release' => 'Released September 24, 1991',
                'image' => 'nirvana-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 10,
                'title' => 'Fleetwood Mac - Rumours',
                'genre' => 'ROCK',
                'release' => 'Released February 4, 1977',
                'image' => 'fleetwood-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 11,
                'title' => 'Taylor Swift - 1989',
                'genre' => 'POP',
                'release' => 'Released October 27, 2014',
                'image' => 'taylor-album.jpg',
                'link' => '#'
            ],
            [
                'id' => 12,
                'title' => 'Pink Floyd - Dark Side of the Moon',
                'genre' => 'PROGRESSIVE ROCK',
                'release' => 'Released March 1, 1973',
                'image' => 'pinkfloyd-album.jpg',
                'link' => '#'
            ]
        ];
        
        return $this->render('albums.html.twig', [
            'active_page' => 'albums',
            'albums' => $albums
        ]);
    }

    public function artists() {
        return $this->render('artists.html.twig', [
            'active_page' => 'artists'
        ]);
    }

    public function about() {
        return $this->render('about.html.twig', [
            'active_page' => 'about'
        ]);
    }

    public function login() {
        return $this->render('login.html.twig', [
            'active_page' => 'login'
        ]);
    }

    public function signup() {
        return $this->render('signup.html.twig', [
            'active_page' => 'signup'
        ]);
    }
}
