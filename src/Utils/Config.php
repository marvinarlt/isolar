<?php

namespace Isolar\Utils;

class Config
{
    /**
     * Stores all added configs.
     * 
     * @var array
     */
    protected $configs = [];

    /**
     * Adds a new config array.
     * 
     * @param string $name
     * @param array $config
     * 
     * @return void
     */
    public function add(string $name, array $config): void
    {
        $this->configs[$name] = $config;
    }

    /**
     * Returns the requested config value.
     * 
     * @param string $name
     * 
     * @return string|array
     */
    public function get(string $name = null): mixed
    {
        if (is_null($name)) {
            return $this->configs;
        }

        if (array_key_exists($name, $this->configs)) {
            return $this->configs[$name];
        }

        return $this->search($name, $this->configs);
    }

    /**
     * Finds the requested value recursively.
     * 
     * @param array|string $needle
     * @param array $haystack
     * @param int $iteration
     * 
     * @return mixed
     */
    protected function search($needle, array $haystack, int $iteration = 0): mixed
    {
        static $result;

        if (is_string($needle)) {
            $needle = explode('.', $needle);
        }

        if (! array_key_exists($iteration, $needle)) {
            $result = $haystack;
        } else {
            $needleString = $needle[$iteration];

            if (! array_key_exists($needleString, $haystack)) {
                return null;
            }
    
            if (is_array($haystack[$needleString])) {
                $this->search($needle, $haystack[$needleString], $iteration + 1);
            } else {
                $result = $haystack[$needleString];
            }
        }

        return $result;
    }
}