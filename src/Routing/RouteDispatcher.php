<?php

namespace Isolar\Routing;

use Isolar\Application;
use Isolar\Collection\RouteCollection;
use Isolar\Collection\MiddlewareCollection;
use Isolar\Routing\Exception\NotFoundException;
use Isolar\Routing\Exception\MethodNotAllowedException;

class RouteDispatcher
{
    /**
     * Stores the RouteCollection instance.
     * 
     * @var RouteCollection
     */
    protected $collection;

    /**
     * Stores the Request instance.
     * 
     * @var Request
     */
    protected $request;

    /**
     * The Application instance.
     * 
     * @var Application
     */
    protected $app;

    /**
     * All base middlewares.
     * 
     * @var array
     */
    protected $middlewares;

    /**
     * @param RouteCollection $collection
     * @param Request $request
     */
    public function __construct(RouteCollection $collection, object $request, Application $app)
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->app = $app;
    }

    /**
     * Sets middlewares.
     * 
     * @param array $middlewares
     * 
     * @return void
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Returns the response from a middleware or a controller.
     * 
     * @param string $method
     * @param string $uri
     * 
     * @return string
     * 
     * @throws MethodNotAllowedException
     */
    public function dispatch(string $method, string $uri): string
    {
        $current = $this->findCurrentRoute($uri);

        if (! $this->checkMethod($current['method'], $method)) {
            throw new MethodNotAllowedException();
        }
        
        if (! isset($current['middlewares'])) {
            $current['middlewares'] = [];
        }
        
        $current['middlewares'] = array_merge($this->middlewares, $current['middlewares']);

        $this->request->setCurrentRoute($current);

        $middlewareResponse = $this->handleMiddlewares($current['middlewares']);

        $controller = new $current['controller'][0]($this->app);
        $method = $current['controller'][1];
        $response = $controller->$method($this->request);

        return $middlewareResponse . $response;
    }

    /**
     * @param array $middlewares
     * 
     * @return mixed
     */
    protected function handleMiddlewares(array $middlewares): mixed
    {
        $collection = new MiddlewareCollection($middlewares);
        $response = '';
        
        while ($collection->count() > $collection->key()) {
            $currentKey = $collection->key();

            if ($collection->count() === $currentKey) {
                break;
            }

            $current = $collection->current();
            $middleware = new $current[0]($this->app);
            $method = $current[1];

            $response .= $middleware->$method($this->request, function () use ($collection) {
                $collection->next();
            });

            if ($collection->key() === $currentKey) {
                break;
            }
        }

        return $response;
    }

    /**
     * Checks if the request method is a valid route method.
     * 
     * @param mixed $allowedMethods
     * @param string $requestMethod
     * 
     * @return bool
     */
    protected function checkMethod(mixed $allowedMethods, string $requestMethod): bool
    {
        $allowedMethods = is_array($allowedMethods) ? implode('|', $allowedMethods) : $allowedMethods;

        if (stripos($allowedMethods, 'any') !== false) {
            return true;
        }

        return stripos($allowedMethods, $requestMethod) !== false ? true : false;
    }

    /**
     * @param string $uri
     * 
     * @return array
     * 
     * @throws NotFoundException
     */
    protected function findCurrentRoute(string $uri): array
    {
        while ($this->collection->count() > $this->collection->key()) {
            $current = $this->collection->current();
            
            if (preg_match($current['processedPath'], $uri, $matches)) {
                unset($matches[0]);

                $parameters = array_values($matches);
                $current['parameters'] = array_combine($current['parameters'], $parameters);

                return $current;
            }
            
            $this->collection->next();
        }

        throw new NotFoundException();
    }
}