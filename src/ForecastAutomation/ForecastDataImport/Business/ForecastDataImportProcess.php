<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ForecastDataImport\Business;

use ForecastAutomation\Activity\ActivityFacade;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Config\ForecastClientQueueConstants;
use ForecastAutomation\ForecastDataImport\ForecastDataImportRepository;
use ForecastAutomation\QueueClient\QueueClientFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;

class ForecastDataImportProcess
{
    public function __construct(
        private ActivityFacade $activityFacade,
        private QueueClientFacade $queueClientFacade,
    ) {
    }

    public function start(): int
    {
        $activityDtoCollection = $this->activityFacade->collect();
        $this->queueClientFacade->sendMessages(
            ForecastClientQueueConstants::QUEUE_NAME,
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
                    ForecastClientQueueConstants::QUEUE_NAME,
                    ForecastClientQueueConstants::IMPORT_EVENT
                );
        }

        return new MessageCollectionDto(...$messages);
    }
}
