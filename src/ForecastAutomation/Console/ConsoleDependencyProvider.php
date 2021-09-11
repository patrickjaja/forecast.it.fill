<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
