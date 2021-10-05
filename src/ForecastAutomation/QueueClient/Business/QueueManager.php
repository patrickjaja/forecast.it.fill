<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Business;

use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Plugin\AdapterPluginInterface;

class QueueManager implements AdapterPluginInterface
{
    public function __construct(
        private AdapterPluginInterface $adapterPlugin
    ) {
    }

    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto): void
    {
        $this->adapterPlugin->sendMessages($queueName, $messageCollectionDto);
    }

    public function consume(string $queueName): void
    {
        $this->adapterPlugin->consume($queueName);
    }
}
