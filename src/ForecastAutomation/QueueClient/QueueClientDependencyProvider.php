<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\KafkaClient\Shared\Plugin\KafkaAdapterPluginPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;

class QueueClientDependencyProvider extends AbstractDependencyProvider
{
    public const QUEUE_ADAPTERS = 'QUEUE_ADAPTERS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::QUEUE_ADAPTERS, $this->createQueueAdapters());
    }

    /**
     * @return \ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface[]
     */
    protected function createQueueAdapters(): array
    {
        return [
            new KafkaAdapterPluginPlugin(),
        ];
    }
}
