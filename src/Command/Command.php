#!/usr/bin/env php
<?php

namespace Console\Command;

use Console\Command\Concerns\HasParameters;
use Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends SymfonyCommand
{
    use HasParameters;

    protected $signature;
    protected $description = '';
    protected $name;
    protected $help = '';
    protected $hidden = false;

    protected $input;
    protected $output;

    public function __construct()
    {
        if (isset($this->signature)) {
            $this->configureUsingFluentDefinition();
        } else {
            parent::__construct($this->name);
        }

        $this->setDescription($this->description);

        $this->setHelp($this->help);

        $this->setHidden($this->hidden);

        if (! isset($this->signature)) {
            $this->specifyParameters();
        }
    }

    protected function configureUsingFluentDefinition()
    {
        [$name, $arguments, $options] = Parser::parse($this->signature);

        parent::__construct($this->name = $name);

        $this->getDefinition()->addArguments($arguments);
        $this->getDefinition()->addOptions($options);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->log = new ConsoleLogger($output);

        $this->input = $input;
        $this->output = $output;

        return (int) $this->handle();
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden)
    {
        parent::setHidden($this->hidden = $hidden);

        return $this;
    }

    abstract protected function handle();
}
