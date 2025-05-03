<?php
/**
 * Twig Configuration
 * 
 * This file configures the Twig templating engine for the application.
 * 
 * References:
 *   Website: https://twig.symfony.com/
 *   Source: https://github.com/twigphp/Twig
 * 
 * - Twig Documentation - Basic API Usage:
 *   URL: https://twig.symfony.com/doc/3.x/api.html
 *   
 * 
 * - Twig Documentation - Environment Options:
 *   URL: https://twig.symfony.com/doc/3.x/api.html#environment-options
 *   
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Create Twig loader
// Reference: https://twig.symfony.com/doc/3.x/api.html#loaders
$loader = new FilesystemLoader(__DIR__ . '/../templates');

// Create Twig environment
// Reference: https://twig.symfony.com/doc/3.x/api.html#environment-options
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../../cache/twig',  // Cache compiled templates for performance
    'debug' => true,                          // Enable debug mode for development
    'auto_reload' => true                     // Automatically reload templates when they change
]);

// Add debug extension
// Reference: https://twig.symfony.com/doc/3.x/functions/dump.html
$twig->addExtension(new \Twig\Extension\DebugExtension());
