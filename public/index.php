<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Create Twig environment
$loader = new FilesystemLoader(__DIR__ . '/includes/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Render the template
echo $twig->render('base.twig', [
    'current_page' => 'home',
    'cart_count' => 3,
    'title' => 'Home - TalkTempo'
]);
