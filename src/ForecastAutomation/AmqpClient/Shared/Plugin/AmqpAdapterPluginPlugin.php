<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient\Shared\Plugin;

use ForecastAutomation\AmqpClient\AmqpClientFacade;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface;

/**
 * @method \ForecastAutomation\AmqpClient\AmqpClientFacade getFacade()
 */
class AmqpAdapterPluginPlugin extends AbstractPlugin implements AdapterPluginInterface
{
    public function __construct(private AmqpClientFacade $amqpClientFacade)
    {
    }

    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto): void
    {
        $this->amqpClientFacade->sendMessages($queueName, $messageCollectionDto);
    }

    public function consume(string $queueName): void
    {
        $this->amqpClientFacade->consume($queueName);
    }
}
