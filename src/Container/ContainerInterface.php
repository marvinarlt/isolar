<?php

namespace Isolar\Container;

interface ContainerInterface
{
    /**
     * Sets the given dependency.
     * 
     * @param string $name
     * @param object $dependency
     * 
     * @return void
     */
    public static function setInstance(string $name, object $dependency): void;

    /**
     * Gets the required dependency.
     * 
     * @param string $name
     * 
     * @return object
     */
    public static function getInstance(string $name): mixed;
}