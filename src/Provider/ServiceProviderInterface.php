<?php

namespace Isolar\Provider;

use Isolar\Application;

interface ServiceProviderInterface
{
    /**
     * Instantiate and returns the service.
     * 
     * @param Application $app
     * 
     * @return object
     */
    public function handle(Application $app): object;
}