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
        // Check for exact route match first
        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path]();
        }
        
        // Check for routes with parameters
        foreach ($this->routes[$method] as $route => $callback) {
            // Skip routes without parameters
            if (strpos($route, '{') === false) {
                continue;
            }
            
            // Convert route pattern to regex
            $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $path, $matches)) {
                // Extract parameter values
                array_shift($matches); // Remove the full match
                
                // Extract parameter names from the route
                preg_match_all('/{([^}]+)}/', $route, $paramNames);
                $params = array_combine($paramNames[1], $matches);
                
                // Call the callback with parameters
                return call_user_func_array($callback, $params);
            }
        }
        
        // Default to home page if route not found
        if ($path === '/') {
            return $this->routes['GET']['/']();
        }
        
        header('HTTP/1.0 404 Not Found');
        return ['template' => 'index.html.twig', 'data' => ['active_page' => 'home']];
    }
}
