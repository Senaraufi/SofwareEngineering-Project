<?php

namespace App\Controllers;

use App\Controller;

class PageController extends Controller {
    public function home() {
        return $this->render('index.html.twig', [
            'active_page' => 'home'
        ]);
    }

    public function browse() {
        return $this->render('browse.html.twig', [
            'active_page' => 'browse'
        ]);
    }

    public function albums() {
        return $this->render('albums.html.twig', [
            'active_page' => 'albums'
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
}
