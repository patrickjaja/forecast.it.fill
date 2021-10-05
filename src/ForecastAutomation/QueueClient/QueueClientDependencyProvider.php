<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\AmqpClient\Shared\Plugin\AmqpAdapterPluginPlugin;
use ForecastAutomation\Kernel\AbstractDependencyProvider;
use ForecastAutomation\Kernel\Locator;
use ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface;

class QueueClientDependencyProvider extends AbstractDependencyProvider
{
    public const QUEUE_ADAPTER = 'QUEUE_ADAPTER';
    public const CONSUMER_PLUGINS = 'CONSUMER_PLUGINS';

    public function provideDependencies(Locator $locator): void
    {
        $this->set(self::QUEUE_ADAPTER, $this->createQueueAdapter());
    }

    protected function createQueueAdapter(): AdapterPluginInterface
    {
        return new AmqpAdapterPluginPlugin();
    }
}
