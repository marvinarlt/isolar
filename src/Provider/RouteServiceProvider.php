<?php

namespace Isolar\Provider;

use Isolar\Application;
use Isolar\Routing\RouteCollector;
use Isolar\Service\RouteService;

class RouteServiceProvider implements ServiceProviderInterface
{
    /**
     * Instantiate and returns the service.
     * 
     * @param Application $app
     * 
     * @return object
     */
    public function handle(Application $app): object
    {
        $routeCollector = $app->getInstance(RouteCollector::class);

        return new RouteService($app, $routeCollector);
    }
}