<?php

namespace Isolar\Provider;

use Isolar\Application;
use Isolar\Collection\AbstractCollection;

class Provider
{
    /**
     * Stores all the service provider.
     * 
     * @var AbstractCollection
     */
    protected $collection;

    /**
     * Stores the application instance.
     * 
     * @var Application
     */
    protected $app;

    /**
     * Creates a new provider.
     * 
     * @param AbstractCollection $collection
     */
    public function __construct(AbstractCollection $collection, Application $app)
    {
        $this->collection = $collection;
        $this->app = $app;
    }

    /**
     * Executes the service provider.
     * Sets the instance of the service.
     * 
     * @return void
     */
    public function run(): void
    {
        while ($this->collection->count() > $this->collection->key()) {
            $current = $this->collection->current();

            $serviceProvider = new $current();
            $service = $serviceProvider->handle($this->app);

            $this->app->setInstance($service::class, $service);
            $this->collection->next();
        }
    }
}