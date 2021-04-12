<?php

use Illuminate\Container\Container;

if (!function_exists('app')) {
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('resolve')) {
    function resolve($name, array $parameters = [])
    {
        return app($name, $parameters);
    }
}

if (! function_exists('swap')) {
    function swap($class, $instance)
    {
        Container::getInstance()->instance($class, $instance);
    }
}
