<?php

namespace Console\Logger;

use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleLog
{

    private $verbosity = 0;

    public function __construct($verbosity = 0)
    {
        $this->verbosity = $verbosity;
    }

    public function log($level, $message): void
    {
        $this->info($message);
    }

    public function debug($message): void
    {
        $this->write('<bg=yellow><fg=black>' . $message . '</></>');
    }

    public function info($message): void
    {
        $this->write('<info>' . $message . '</info>');
    }

    public function notice($message): void
    {
        $this->write('<fg=white>' . $message . '</>');
    }

    public function warning($message): void
    {
        $this->write('<fg=yellow>' . $message . '</>');
    }

    public function error($message): void
    {
        $this->write('<fg=red>' . $message . '</>');
    }

    public function critical($message): void
    {
        $this->write('<fg=red>' . $message . '</>');
    }

    private function write($output)
    {
        if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'testing') {
            return;
        }

        (new ConsoleOutput)->writeln($this->verbosity . ': '. $output);
    }

}
