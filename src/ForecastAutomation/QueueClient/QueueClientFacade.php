<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient;

use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;

/**
 * @method \ForecastAutomation\QueueClient\QueueClientFactory getFactory()
 */
class QueueClientFacade extends AbstractFacade
{
    public function __construct(private QueueClientFactory $queueClientFactory)
    {
    }

    public function consume(string $queueName): void
    {
        $this->queueClientFactory->createQueueManager()->consume($queueName);
    }

    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto): void
    {
        $this->queueClientFactory->createQueueManager()->sendMessages($queueName, $messageCollectionDto);
    }
}
