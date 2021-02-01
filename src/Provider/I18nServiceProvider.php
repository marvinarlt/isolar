<?php

namespace Isolar\Provider;

use Isolar\Application;
use Isolar\Utils\Config;
use Isolar\Service\I18nService;

class I18nServiceProvider implements ServiceProviderInterface
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
        $config = $app->getInstance(Config::class);

        return new I18nService($config->get('i18n'));
    }
}