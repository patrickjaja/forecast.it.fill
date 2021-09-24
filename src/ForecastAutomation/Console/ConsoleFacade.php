<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Console;

use ForecastAutomation\Kernel\AbstractFacade;
use Symfony\Component\Console\Application;

/**
 * @method ConsoleFactory getFactory()
 */
class ConsoleFacade extends AbstractFacade
{
    public function installConsoleCommands(Application $application): void
    {
        $this->getFactory()->createConsoleCommandInstaller($application)->install();
    }
}
