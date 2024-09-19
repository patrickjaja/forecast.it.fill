<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Console;

use ForecastAutomation\Activity\Shared\Plugin\ImportActivityConsoleCommandPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\QueueClient\Shared\Plugin\QueueClientConsumerConsoleCommandPlugin;

class ConsoleDependencyProvider extends AbstractDependencyProvider
{
    public const CONSOLE_PLUGINS = 'CONSOLE_PLUGINS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(
            self::CONSOLE_PLUGINS,
            [
                $this->createImportActivityConsoleCommandPlugin(),
                $this->createQueueClientConsumerConsoleCommandPlugin(),
            ]
        );
    }

    protected function createImportActivityConsoleCommandPlugin(): ImportActivityConsoleCommandPlugin
    {
        return new ImportActivityConsoleCommandPlugin();
    }

    protected function createQueueClientConsumerConsoleCommandPlugin(): QueueClientConsumerConsoleCommandPlugin
    {
        return new QueueClientConsumerConsoleCommandPlugin();
    }
}
