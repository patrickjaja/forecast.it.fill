<?php

namespace ForecastAutomation\Console;

use ForecastAutomation\Kernel\AbstractFactory;
use Symfony\Component\Console\Application;

class ConsoleFactory extends AbstractFactory
{
    public function getConsoleCommandPlugins(): array
    {
        return $this->getProvidedDependency(ConsoleDependencyProvider::CONSOLE_PLUGINS);
    }

    public function createConsoleCommandInstaller(Application $application): ConsoleCommandInstaller
    {
        return new ConsoleCommandInstaller($application, $this->getConsoleCommandPlugins());
    }
}
