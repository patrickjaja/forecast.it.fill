<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\AmqpClient;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;

/**
 * @method \ForecastAutomation\AmqpClient\AmqpClientFactory getFactory()
 */
class AmqpClientFacade extends AbstractFacade
{
    public function __construct(private AmqpClientFactory $amqpClientFactory)
    {
    }

    public function sendMessages($queueName, MessageCollectionDto $messageCollectionDto): void
    {
        $this->amqpClientFactory->createProducer()->sendMessages($queueName, $messageCollectionDto);
    }

    public function consume(string $queueName): void
    {
        $this->amqpClientFactory->createConsumer()->consume($queueName);
    }
}
