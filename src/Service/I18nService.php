<?php

namespace Isolar\Service;

class I18nService
{
    /**
     * The default config.
     * 
     * @var array
     */
    protected $defaultConfig = [
        'locale' => 'en',
        'directory' => '',
        'avaible' => ['en']
    ];

    /**
     * The custom config.
     * 
     * @var array
     */
    protected $config;

    /**
     * The current locale.
     * 
     * @var string
     */
    protected $locale;

    /**
     * The translated content of a json file.
     * 
     * @var array
     */
    protected $translation = [];

    /**
     * Sets some config parameters.
     * 
     * @param string $default
     * @param string $directory
     * @param string $avaible
     */
    public function __construct(array $config)
    {
        $this->config = array_merge($this->defaultConfig, $config);
    }

    /**
     * Sets the locale.
     * 
     * @param string $locale
     * 
     * @return void
     */
    public function setLocale(string $locale): void
    {
        if (empty($locale) || ! in_array($locale, $this->config['avaible'])) {
            $locale = $this->config['locale'];
        }

        $this->locale = $locale;
    }

    /**
     * Loads the translation file.
     * 
     * @return void
     */
    public function loadTranslation(): void
    {
        $file = sprintf('%s/%s.php', $this->config['directory'], $this->locale);

        if (! file_exists($file)) {
            return;
        }

        $this->translation = include $file;
        $this->translation['avaible'] = $this->config['avaible'];
    }

    /**
     * Returns the translation.
     * 
     * @return array
     */
    public function getTranslation(): array
    {
        return $this->translation;
    }
}