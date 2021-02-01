<?php

namespace Isolar\Middleware;

use Isolar\Application;

abstract class AbstractMiddleware
{
    /**
     * The Application instance.
     * 
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}