<?php

namespace Isolar\Service;

use Isolar\Http\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class ViewService
{
    /**
     * Stores the view config.
     * 
     * @var array
     */
    protected $config;

    /**
     * Stores the translation array.
     * 
     * @var array $translation
     */
    protected $translation;

    /**
     * Stores the request instance.
     * 
     * @var Request
     */
    protected $request;

    /**
     * @param array $translation
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Renders a twig based view.
     * 
     * @param string $template
     * @param array $data
     * 
     * @return string
     */
    public function render(string $template, array $data): string
    {
        $template = $template . '.twig';

        $loader = new FilesystemLoader($this->config['directory']);
        $twig = new Environment($loader, [
            'debug' => $this->config['debug']
        ]);

        $twig->addExtension(new DebugExtension());

        $globalData = [
            'translation' => $this->translation,
            'page' => $this->getPageContent()
        ];

        $data = array_merge($globalData, $data);

        return $twig->render($template, $data);
    }

    /**
     * Returns the page data for the view.
     * 
     * @return array
     */
    protected function getPageContent(): array
    {
        return [
            'root' => $this->request->getRoot(),
            'parameter' => $this->request->getParameter(),
            'seo' => $this->getPageSeo()
        ];
    }

    /**
     * Returns the page seo variables.
     * 
     * @return array
     */
    protected function getPageSeo(): array
    {
        $route = $this->request->getCurrentRoute();

        if (! isset($route['name'])) {
            return [];
        }

        if (! isset($this->translation[$route['name']])) {
            return [];
        }
        
        return $this->translation[$route['name']];
    }

    /**
     * Sets the current translation.
     * 
     * @param array $translation
     * 
     * @return void
     */
    public function setTranslation(array $translation): void
    {
        $this->translation = $translation;
    }

    /**
     * Sets the request.
     * 
     * @param Request $request
     * 
     * @return void
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}