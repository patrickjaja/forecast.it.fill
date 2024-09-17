<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\Activity\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ProjektronClient\Shared\Config\ProjektronClientQueueConstants;
use ForecastAutomation\QueueClient\QueueClientFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;

class ActivitySendQueueProcess
{
    public function __construct(
        private QueueClientFacade $queueClientFacade,
    ) {
    }

    public function send(ActivityDtoCollection $activityDtoCollection): int
    {
        $this->queueClientFacade->sendMessages(
            ProjektronClientQueueConstants::QUEUE_NAME,
            $this->createMessageCollectionDto($activityDtoCollection)
        );

        return \count($activityDtoCollection->activityDtos);
    }

    private function createMessageCollectionDto(ActivityDtoCollection $activityDtoCollection): MessageCollectionDto
    {
        $messages = [];
        foreach ($activityDtoCollection as $activityDto) {
            $messages[] =
                new MessageDto(
                    ['created' => $activityDto->created->format('c')] + (array) $activityDto,
                    ProjektronClientQueueConstants::QUEUE_NAME, // ToDo: Move to output plugin
                    ProjektronClientQueueConstants::IMPORT_EVENT
                );
        }

        return new MessageCollectionDto(...$messages);
    }
}
