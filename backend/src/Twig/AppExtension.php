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

    public function generatePath(string $route, array $params = []): string
    {
        // Basic URL generation - you might want to enhance this based on your needs
        $path = '/' . ltrim($route, '/');
        
        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }
        
        return $path;
    }
}
