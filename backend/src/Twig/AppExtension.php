<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('path', [$this, 'generatePath'])
        ];
    }

    /**
     * Generates a URL path based on the route name and parameters
     * 
     * This method implements a simplified version of Symfony's path() function
     * for URL generation in templates.
     * 
     * @param string $route The route name or path
     * @param array $params Optional query parameters
     * @return string The generated URL
     * 
     * @see https://symfony.com/doc/current/routing.html#generating-urls
     * @see https://www.php.net/manual/en/function.http-build-query.php
     */
    public function generatePath(string $route, array $params = []): string
    {
        // Basic URL generation 
        $path = '/' . ltrim($route, '/');
        
        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }
        
        return $path;
    }
}
