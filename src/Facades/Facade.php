<?php

namespace Console\Facades;

use Illuminate\Container\Container;
use RuntimeException;

class Facade
{
    protected static $app;
    protected static $class = null;
    protected static $resolvedInstance;

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(Container::getInstance()->make(static::$class ?: static::getClass()));
    }

    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (static::$app) {
            return static::$resolvedInstance[$name] = static::$app[$name];
        }
    }

    protected static function getClass()
    {
        throw new RuntimeException('Facade does not implement getClass method.');
    }
}
