<?php

namespace Console\Process;

use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{

    protected $timeout = null;
    protected $quiet = false;

    /**
     * Run the given command.
     *
     * @param  string|array  $command
     * @param  callable $onError
     * @return string
     */
    public function run($command, callable $onError = null)
    {

        if (is_array($command) || $command instanceof Arrayable) {
            $process = new SymfonyProcess($command);
        } else {
            $process = SymfonyProcess::fromShellCommandline($command);
        }

        ($this->quiet) && $process->disableOutput();

        $process->setTimeout($this->timeout)->run();

        if (!$process->isSuccessful() && !$this->quiet) {
            ($onError !== null)
                && $onError($process->getExitCode(), $process->getOutput())
                || throw new ProcessFailedException($process);
        }

        return ($this->quiet) ? '' : $process->getOutput();
    }
}
