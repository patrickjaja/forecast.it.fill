<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\QueueClient\Shared\Plugin;

use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;

interface SenderInterface
{
    public function sendMessages(string $queueName, MessageCollectionDto $messageCollectionDto): void;
}
