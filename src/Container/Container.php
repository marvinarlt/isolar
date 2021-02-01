<?php

namespace Isolar\Container;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected static $dependencies;

    /**
     * Sets the given dependency.
     * 
     * @param string $name
     * @param object $dependency
     * 
     * @return void
     */
    public static function setInstance(string $name, object $dependency): void
    {
        static::$dependencies[$name] = $dependency;
    }

    /**
     * Gets the required dependency.
     * 
     * @param string $name
     * 
     * @return object
     */
    public static function getInstance(string $name): mixed
    {
        if (! isset(static::$dependencies[$name])) {
            return null;
        }

        return static::$dependencies[$name];
    }
}