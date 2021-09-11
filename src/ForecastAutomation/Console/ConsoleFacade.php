<?php

namespace ForecastAutomation\Console;

use ForecastAutomation\Kernel\AbstractFacade;
use Symfony\Component\Console\Application;

/**
 * @method ConsoleFactory getFactory()
 */
class ConsoleFacade extends AbstractFacade
{
    public function installConsoleCommands(Application $application): void {
        $this->getFactory()->createConsoleCommandInstaller($application)->install();
    }
}
