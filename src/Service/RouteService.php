<?php

namespace Isolar\Service;

use Isolar\Application;
use Isolar\Collection\RouteCollection;
use Isolar\Routing\RouteCollector;
use Isolar\Routing\RouteDispatcher;

class RouteService
{
    /**
     * The Application instance.
     * 
     * @var Application
     */
    protected $app;

    /**
     * Stores all routes.
     * 
     * @var RouteCollector
     */
    protected $collector;

    /**
     * The base middlewares for every route.
     * 
     * @var array
     */
    protected $middlewares = [];

    /**
     * Stores all routes as collection.
     * 
     * @var RouteCollection
     */
    protected $collection;

    /**
     * @param RouteCollector $collector
     */
    public function __construct(Application $app, RouteCollector $collector)
    {
        $this->app = $app;
        $this->collector = $collector;
        $this->collection = $this->collectorToCollection($this->collector);
    }

    /**
     * Adds base middlewares.
     * 
     * @param array $middlewares
     * 
     * @return void
     */
    public function addMiddlewares(array $middlewares): void
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
    }

    /**
     * Resolves the current request.
     * Returns the response form a middleware or controller.
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function resolveRequest(object $request): string
    {
        $dispatcher = new RouteDispatcher($this->collection, $request, $this->app);
        $dispatcher->setMiddlewares($this->middlewares);

        return $dispatcher->dispatch($request->getMethod(), $request->getUri());
    }

    /**
     * Creates a new collection from a collector.
     * 
     * @param RouteCollector $collector
     * 
     * @return void
     */
    protected function collectorToCollection(RouteCollector $collector): RouteCollection
    {
        return new RouteCollection($collector->getAll());
    }
}