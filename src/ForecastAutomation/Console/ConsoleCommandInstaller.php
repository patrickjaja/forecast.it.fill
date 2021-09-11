<?php

namespace ForecastAutomation\Console;

use Symfony\Component\Console\Application;

/**
 * @method ConsoleFactory getFactory()
 */
class ConsoleCommandInstaller
{
    public function __construct(private Application $application, private array $consoleCommands) { }

    public function install(): Application {
        foreach ($this->consoleCommands as $consoleCommand) {
            $this->application->add($consoleCommand);
        }

        return $this->application;
    }
}
