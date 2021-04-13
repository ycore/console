#!/usr/bin/env php
<?php

namespace Console\Command;

use Console\Logger\ConsoleLog;

class Command
{
    public const SUCCESS = 0;
    public const FAILURE = 1;

    public function __construct(
        private ConsoleLog $log,
    ) {}
}
