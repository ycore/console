<?php

namespace Console\Process;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
    /**
     * Run a command quietly as the current user.
     *
     * @param  string  $command
     * @return void
     */
    public function quietly($command)
    {
        $this->runCommand($command.' > /dev/null 2>&1');
    }

    /**
     * Run a command as the current user.
     *
     * @param  string  $command
     * @param  callable $onError
     * @return string
     */
    public function run($command, callable $onError = null)
    {
        return $this->runCommand($command, $onError);
    }

    /**
     * Run the given command.
     *
     * @param  string  $command
     * @param  callable $onError
     * @return string
     */
    private function runCommand($command, callable $onError = null)
    {
        $onError = $onError ?: function (): void {
        };
        $process = SymfonyProcess::fromShellCommandline($command);
        $processOutput = '';

        $process->setTimeout(null)->run(function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        });

        if ($process->getExitCode() > 0) {
            $onError($process->getExitCode(), $processOutput);
        }

        return $processOutput;
    }
}
