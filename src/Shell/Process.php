<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Shell;

use DevDeeper\ZATCA\Exceptions\ShellCommandFailedException;
use Symfony\Component\Process\Process as SymfonyProcess;

class Process
{
    public static function run(string $cmd): string
    {
        $process = SymfonyProcess::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)->run($captureOutput);

        if ($process->getExitCode()) {
            throw new ShellCommandFailedException($cmd.' - '.$processOutput);
        }

        return $processOutput;
    }
}
