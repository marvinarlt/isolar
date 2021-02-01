<?php

namespace Isolar\Container;

abstract class AbstractContainer
{
    /**
     * @var array
     */
    protected $dependencies;

    /**
     * Sets the given dependency.
     * 
     * @param string $name
     * @param object $dependency
     * 
     * @return void
     */
    public function setInstance(string $name, object $dependency): void
    {
        $this->dependencies[$name] = $dependency;
    }

    /**
     * Gets the required dependency.
     * 
     * @param string $name
     * 
     * @return object
     */
    public function getInstance(string $name): mixed
    {
        if (! isset($this->dependencies[$name])) {
            return null;
        }

        return $this->dependencies[$name];
    }
}