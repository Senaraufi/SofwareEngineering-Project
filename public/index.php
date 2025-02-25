<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Create Twig environment
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Get the requested path
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Simple routing
switch ($path) {
    case '':
    case 'index':
    case 'home':
        $template = 'index.html.twig';
        $active_page = 'home';
        break;
    case 'browse':
        $template = 'browse.html.twig';
        $active_page = 'browse';
        break;
    case 'albums':
        $template = 'albums.html.twig';
        $active_page = 'albums';
        break;
    case 'artists':
        $template = 'artists.html.twig';
        $active_page = 'artists';
        break;
    case 'about':
        $template = 'about.html.twig';
        $active_page = 'about';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        $template = 'index.html.twig';
        $active_page = 'home';
}

// Sample data - in a real app, this would come from a database
$cart_count = 3;
$current_track = [
    'title' => 'Sample Track',
    'artist' => 'Sample Artist'
];

// Render the template
echo $twig->render($template, [
    'active_page' => $active_page,
    'cart_count' => $cart_count,
    'current_track' => $current_track
]);
