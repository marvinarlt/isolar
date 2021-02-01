<?php

namespace Isolar\Routing;

class RouteCollector
{
    /**
     * Stores all added routes.
     * 
     * @var array
     */
    protected $routes = [];

    /**
     * Adds a route.
     * 
     * @param array $route
     * 
     * @return void
     */
    public function add(array $route): void
    {
        $processedRoute = $this->processRoute($route);
        $processedI18nRoute = $this->processI18nRoute($route);

        $this->routes[] = $processedRoute;
        $this->routes[] = $processedI18nRoute;
    }

    /**
     * Returns all added routes.
     * 
     * @return array
     */
    public function getAll(): array
    {
        return $this->routes;
    }
    
    /**
     * Processes the route.
     * 
     * @param array $route
     * 
     * @return array
     */
    protected function processRoute(array $route): array
    {
        $processedPath = $this->processPath($route['path']);

        $route['processedPath'] = $processedPath['path'];
        $route['parameters'] = $processedPath['parameters'];

        return $route;
    }

    /**
     * Turns a route into a i18n route.
     * 
     * @param array $route
     * 
     * @return array
     */
    protected function processI18nRoute(array $route): array
    {
        $route['path'] = sprintf('/{locale:[a-zA-Z]{2}}%s', $route['path']);
        $route['name'] = sprintf('locale_%s', $route['name']);

        return $this->processRoute($route);
    }

    /**
     * Turns the path into a regular expression.
     * 
     * @param string $path
     * 
     * @return array
     */
    protected function processPath(string $path)
    {
        $exploded = explode('/', $path);
        $filtered = array_filter($exploded);

        $parts = [];
        $parameterNames = [];

        foreach ($filtered as $part) {
            if (strpos($part, '{') !== 0) {
                $parts[] = $part;
                continue;
            }

            $regex = substr($part, 1, -1);
            $explodedRegex = explode(':', $regex);
            $regex = isset($explodedRegex[1]) ? $explodedRegex[1] : '\w+';

            $parameterNames[] = $explodedRegex[0];
            $parts[] = sprintf('(%s)', $regex);
        }
        
        $path = '/' . implode('/', $parts);
        $path = sprintf('~^%s$~', $path);

        return [
            'path' => $path,
            'parameters' => $parameterNames
        ];
    }
}