<?php

return [

    /**
     * App Name
     * --------
     * 
     * Set the name of your project.
     * 
     */
    'name' => 'Isolar',

    /**
     * App Version
     * -----------
     * 
     * Set the version of your project.
     * 
     */
    'version' => '0.1',

    /**
     * Providers
     * ---------
     * 
     * Define the provider in the order they should be loaded.
     * You can define more if you need.
     * 
     */
    'providers' => [
        Isolar\Provider\I18nServiceProvider::class,
        Isolar\Provider\RouteServiceProvider::class,
        Isolar\Provider\ViewServiceProvider::class
    ],

    /**
     * Middlewares
     * -----------
     * 
     * Define global middlewares in the order they should be loaded.
     * 
     */
    'middlewares' => [
        [Isolar\Middleware\I18nMiddleware::class, 'handle'],
        [Isolar\Middleware\ViewMiddleware::class, 'handle']
    ]

];