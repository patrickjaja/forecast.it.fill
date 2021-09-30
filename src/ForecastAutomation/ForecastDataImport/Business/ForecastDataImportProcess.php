<?php

declare(strict_types = 1);

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
use ForecastAutomation\ForecastDataImport\Business\Writer\ForecastActivityWriter;
use ForecastAutomation\QueueClient\QueueClientFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;
use ForecastAutomation\Serializer\SerializerFacade;

class ForecastDataImportProcess
{
    public function __construct(
        private ActivityFacade $activityFacade,
        private ForecastActivityWriter $forecastActivityWriter,
        private QueueClientFacade $queueClientFacade,
        private SerializerFacade $serializerFacade,
    ) {
    }

    public function start(): int
    {
        $activityDtoCollection = $this->activityFacade->collect();
        $this->queueClientFacade->sendMessages(
            ForecastClientQueueConstants::QUEUE_NAME,
            $this->createMessageCollectionDto($activityDtoCollection)
        );

        return \count((array)$activityDtoCollection);
//        return $this->forecastActivityWriter->writeActivities();
    }

    private function createMessageCollectionDto(ActivityDtoCollection $activityDtoCollection): MessageCollectionDto
    {
        $messages = [];
        foreach ($activityDtoCollection as $activityDto) {
            $messages[] =
                new MessageDto(
                    (array)$activityDto + [ //ToDO: Change for multi project/person support
                        'FORECAST_PROJECT_ID' => $_ENV['FORECAST_PROJECT_ID'],
                        'FORECAST_PERSON_ID' => $_ENV['FORECAST_PROJECT_ID'],
                        'FORECAST_FALLBACK_TASK_ID' => $_ENV['FORECAST_FALLBACK_TASK_ID'],
                    ],
                    self::class,
                    ForecastClientQueueConstants::IMPORT_EVENT
                );
        }
        return new MessageCollectionDto(...$messages);
    }
}
