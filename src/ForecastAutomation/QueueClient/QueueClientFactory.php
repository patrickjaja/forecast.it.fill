<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\AmqpClient\AmqpClientFacade;
use ForecastAutomation\AmqpClient\AmqpClientFactory;
use ForecastAutomation\AmqpClient\Shared\Plugin\AmqpAdapterPluginPlugin;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\QueueClient\Business\QueueManager;

class QueueClientFactory extends AbstractFactory
{
    public function __construct(private AmqpAdapterPluginPlugin $amqpAdapterPluginPlugin)
    {
    }

    public function createQueueManager(): QueueManager
    {
        //ToDo: Figure our symfony way
        return new QueueManager($this->amqpAdapterPluginPlugin);
    }
}
