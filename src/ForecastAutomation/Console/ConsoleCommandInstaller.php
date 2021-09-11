<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Console;

use Symfony\Component\Console\Application;

/**
 * @method ConsoleFactory getFactory()
 */
class ConsoleCommandInstaller
{
    public function __construct(private Application $application, private array $consoleCommands)
    {
    }

    public function install(): Application
    {
        foreach ($this->consoleCommands as $consoleCommand) {
            $this->application->add($consoleCommand);
        }

        return $this->application;
    }
}
