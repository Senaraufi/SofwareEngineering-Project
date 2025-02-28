<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Create Twig loader
$loader = new FilesystemLoader(__DIR__ . '/../templates');

// Create Twig environment
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../../cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Add debug extension
$twig->addExtension(new \Twig\Extension\DebugExtension());
