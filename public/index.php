<?php

include_once __DIR__ . '/../vendor/autoload.php';

/**
 * Create a new Application instance.
 */
$app = new \Isolar\Application(dirname(__DIR__));

/**
 * Add configs for the project.
 */
$app->configure('/config/app.php');
$app->configure('/config/i18n.php');
$app->configure('/config/view.php');

/**
 * Add routes for the project.
 */
$app->addRoutes('/routes/web.php');

/**
 * Run the app an display the response.
 */
echo $app->run();