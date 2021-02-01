<?php

use Isolar\Controller\HomeController;

return [

    /**
     * Routes
     * ------
     * 
     * Define here the routes for your project.
     * You can also add a new file in this directory
     * and load that in the public/index.php.
     * 
     */

    [
        'name' => 'home',
        'path' => '/',
        'method' => 'GET',
        'controller' => [HomeController::class, 'viewAction']
    ]

];