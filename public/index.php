<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Router;
use App\Controllers\PageController;

// Create Twig environment
$loader = new FilesystemLoader(__DIR__ . '/../frontend/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../backend/cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Initialize router
$router = new Router();
$pageController = new PageController();

// Define routes
$router->get('/', [$pageController, 'home']);
$router->get('/browse', [$pageController, 'browse']);
$router->get('/albums', [$pageController, 'albums']);
$router->get('/artists', [$pageController, 'artists']);
$router->get('/about', [$pageController, 'about']);
$router->get('/login', [$pageController, 'login']);
$router->get('/signup', [$pageController, 'signup']);

// Get the requested path and method
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Dispatch the request
$result = $router->dispatch($method, $path);

// Render the template
echo $twig->render($result['template'], $result['data']);
