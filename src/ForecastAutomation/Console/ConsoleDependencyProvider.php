<?php

namespace ForecastAutomation\Console;

use ForecastAutomation\ForecastDataImport\Shared\Plugin\ForecastImportActivityConsoleCommandPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;

class ConsoleDependencyProvider extends AbstractDependencyProvider
{
    public const CONSOLE_PLUGINS = 'CONSOLE_PLUGINS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::CONSOLE_PLUGINS, [$this->createTestConsoleCommand()]);
    }

    protected function createTestConsoleCommand(): ForecastImportActivityConsoleCommandPlugin
    {
        return new ForecastImportActivityConsoleCommandPlugin();
    }
}
