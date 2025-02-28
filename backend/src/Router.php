<?php

namespace App;

class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch($method, $path) {
        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path]();
        }
        
        // Default to home page if route not found
        if ($path === '/') {
            return $this->routes['GET']['/']();
        }
        
        header('HTTP/1.0 404 Not Found');
        return ['template' => 'index.html.twig', 'data' => ['active_page' => 'home']];
    }
}
