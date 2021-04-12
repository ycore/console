#!/usr/bin/env php
<?php

namespace Console;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    public function loadCommands(
        $glob = __DIR__ . 'Commands/*Command.php',
        $namespace = 'Commands\\',
        Container $container = null)
    {
        foreach (glob($glob) as $command) {
            $class = $namespace . rtrim(basename($command), ".php");
            $this->addCommands(array(new $class($container)));
        }
    }
}
