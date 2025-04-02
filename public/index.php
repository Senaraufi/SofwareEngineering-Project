<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Router;
use App\Controllers\PageController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\ArtistController;
use App\Twig\AppExtension;

// Create Twig environment
$loader = new FilesystemLoader(__DIR__ . '/../frontend/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../backend/cache/twig',
    'debug' => true,
    'auto_reload' => true
]);

// Add custom extensions
$twig->addExtension(new AppExtension());

// Initialize router
$router = new Router();
$pageController = new PageController();
$userController = new UserController();
$adminController = new AdminController();
$artistController = new ArtistController();

// Define routes
$router->get('/', [$pageController, 'home']);
$router->get('/browse', [$pageController, 'browse']);
$router->get('/albums', [$pageController, 'albums']);
$router->get('/artists', [$artistController, 'index']);
$router->get('/about', [$pageController, 'about']);
$router->get('/login', [$userController, 'login']);
$router->post('/login', [$userController, 'processLogin']);
$router->get('/signup', [$userController, 'signup']);
$router->post('/signup', [$userController, 'processSignup']);
$router->get('/logout', [$userController, 'logout']);

// Artist routes
$router->get('/artist/{id}', [$artistController, 'show']);

// Admin routes
$router->get('/admin/users', [$adminController, 'users']);
$router->get('/admin/users/edit/{id}', [$adminController, 'editUser']);
$router->post('/admin/users/edit/{id}', [$adminController, 'editUser']);
$router->get('/admin/users/delete/{id}', [$adminController, 'deleteUser']);

// Get the requested path and method
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Dispatch the request
$result = $router->dispatch($method, $path);

// Render the template
echo $twig->render($result['template'], $result['data']);
