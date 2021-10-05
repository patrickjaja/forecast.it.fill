<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Config\ForecastClientQueueConstants;
use ForecastAutomation\PeriodicalActivityDataImport\Shared\Dto\PeriodicalActivityConfigDto;
use ForecastAutomation\QueueClient\QueueClientFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;

class PeriodicalActivityDataImportProcess
{
    public const PERIODICAL_SUFFIX = 'Geplanter Termin';

    public function __construct(
        private PeriodicalActivityConfigReader $periodicalActivityConfigReader,
        private QueueClientFacade $queueClientFacade
    ) {
    }

    public function start(string $periodicalDate): int
    {
        $activityDtoCollection = $this->generateActivity(
            $this->periodicalActivityConfigReader->readPeriodicalConfig($periodicalDate),
            $periodicalDate
        );

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

    private function generateActivity(
        array $periodicalConfigDtoCollection,
        string $periodicalDate
    ): ActivityDtoCollection {
        $activityDtoArray = [];
        /** @var PeriodicalActivityConfigDto $periodicalConfigDto */
        foreach ($periodicalConfigDtoCollection as $periodicalConfigDto) {
            $activityDtoArray[] = new ActivityDto(
                $periodicalConfigDto->project_id,
                sprintf('%s: %s', self::PERIODICAL_SUFFIX, $periodicalConfigDto->note),
                new \DateTime(date('d-m-Y', strtotime($periodicalDate))),
                $periodicalConfigDto->duration
            );
        }

        return new ActivityDtoCollection(...$activityDtoArray);
    }
}
