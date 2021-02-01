<?php

namespace Isolar;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Isolar\Container\AbstractContainer;
use Isolar\Utils\Config;
use Isolar\Http\Request;
use Isolar\Routing\RouteCollector;
use Isolar\Collection\ProviderCollection;
use Isolar\Provider\Provider;
use Isolar\Service\RouteService;

class Application extends AbstractContainer
{
    /**
     * Stores the base directory path.
     * 
     * @var string
     */
    protected $rootDirectory;

    /**
     * Stores the Config instance.
     * 
     * @var Config
     */
    protected $config;

    /**
     * Stores the RouteCollector instance.
     * 
     * @var RouteCollector
     */
    protected $routeCollector;

    /**
     * Creates the application.
     * Sets the root directory for the project.
     * 
     * @param string $rootDirectory
     */
    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;

        $this->bootstrapErrorHandling();
        $this->bootstrapConfig();
        $this->bootstrapRouting();

        // $this->setInstance($this::class, $this);
    }

    /**
     * Adds the config.
     * 
     * @param string $relativePath
     * 
     * @return void
     */
    public function configure(string $relativePath): void
    {
        $config = $this->loadFile($relativePath);

        if (is_null($config)) {
            return;
        }

        $this->config->add($config['name'], $config['contents']);
    }

    /**
     * Adds the routes array to the router.
     * 
     * @param string $relativePath
     * 
     * @return void
     */
    public function addRoutes(string $relativePath): void
    {
        $routes = $this->loadFile($relativePath);

        if (is_null($routes) || empty($routes['contents'])) {
            return;
        }

        foreach ($routes['contents'] as $route) {
            $this->routeCollector->add($route);
        }
    }

    /**
     * Runs the app.
     * 
     * @return string
     */
    public function run(): string
    {
        $this->loadServiceProvider();

        $routeService = $this->getInstance(RouteService::class);
        $routeService->addMiddlewares($this->config->get('app.middlewares'));

        return $routeService->resolveRequest(Request::createFromGlobals());
    }

    /**
     * Initializes the error handling.
     * 
     * @return void
     */
    protected function bootstrapErrorHandling(): void
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();
    }

    /**
     * Initializes the config handler.
     * 
     * @return void
     */
    protected function bootstrapConfig()
    {
        $this->config = new Config();

        $this->setInstance($this->config::class, $this->config);
    }

    /**
     * Initializes the routing system.
     * 
     * @return void
     */
    protected function bootstrapRouting(): void
    {
        $this->routeCollector = new RouteCollector();

        $this->setInstance($this->routeCollector::class, $this->routeCollector);
    }

    /**
     * Adds service provider to the collection.
     * 
     * @return void
     */
    protected function loadServiceProvider(): void
    {
        $collection = new ProviderCollection($this->config->get('app.providers'));
        $provider = new Provider($collection, $this);

        $provider->run();
    }

    /**
     * Loads the returned contents of a file.
     * 
     * @param string $relativePath
     * 
     * @return array
     */
    protected function loadFile(string $relativePath): array
    {
        if (! is_string($relativePath)) {
            return null;
        }

        $filePath = $this->rootDirectory . $relativePath;

        if (! file_exists($filePath)) {
            return null;
        }

        return [
            'contents' => @include $filePath,
            'name' => pathinfo($filePath, PATHINFO_FILENAME)
        ];
    }
}