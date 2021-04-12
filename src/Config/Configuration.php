<?php

namespace Console\Config;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;

class Configuration
{
    private $items = [];

    /**
     * Load config from yaml file into a collection.
     *
     * @param null|string $file
     *
     * @return void
     */
    public function load(?string $file = null): void
    {
        $this->items = Yaml::parseFile($file);
    }

    /**
     * Get a config item using "dot" notation.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->items, $key, $value);
        }
    }
}
