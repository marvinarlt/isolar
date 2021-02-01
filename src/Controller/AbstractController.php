<?php

namespace Isolar\Controller;

use Isolar\Application;
use Isolar\Service\ViewService;

abstract class AbstractController
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

    /**
     * Renders the view with twig.
     * 
     * @param string $template
     * @param array $data
     * 
     * @return string
     */
    public function view(string $template, array $data = []): string
    {
        $viewService = $this->app->getInstance(ViewService::class);

        return $viewService->render($template, $data);
    }
}