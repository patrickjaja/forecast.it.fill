<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Console;

use ForecastAutomation\Console\Business\ConsoleCommandInstaller;
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
