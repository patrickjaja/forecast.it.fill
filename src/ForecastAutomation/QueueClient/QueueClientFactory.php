<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\QueueClient\Business\QueueManager;
use ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface;

class QueueClientFactory extends AbstractFactory
{
    public function createQueueManager(): QueueManager
    {
        return new QueueManager($this->getQueueAdapters());
    }

    /**
     * @return AdapterPluginInterface[] array
     */
    public function getQueueAdapters(): array
    {
        return $this->getProvidedDependency(QueueClientDependencyProvider::QUEUE_ADAPTERS);
    }
}
