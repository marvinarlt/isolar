<?php

namespace Isolar\Service;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
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
            'translation' => $this->translation
        ];

        $data = array_merge($globalData, $data);

        return $twig->render($template, $data);
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
}