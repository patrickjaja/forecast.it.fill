<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Config\ForecastClientQueueConstants;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginInterface;

/**
 * @method \ForecastAutomation\ProjektronClient\ProjektronClientFacade getFacade()
 */
class ProjektronClientQueuePluginPlugin extends AbstractPlugin implements QueuePluginInterface
{
    public function getQueueName(): string
    {
        return ForecastClientQueueConstants::QUEUE_NAME;
    }

    public function consumeMessage(MessageDto $messageDto): bool
    {
        $this->getFacade()->writeActivities(new ActivityDtoCollection($this->createActivityDto($messageDto)));

        return true;
    }

    private function createActivityDto(MessageDto $messageDto)
    {
        return new ActivityDto(
            $messageDto->data['needle'],
            $messageDto->data['description'],
            new \DateTime($messageDto->data['created']),
            (int) $messageDto->data['duration']
        );
    }
}
