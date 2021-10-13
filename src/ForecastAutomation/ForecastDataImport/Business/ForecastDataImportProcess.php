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
use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\ForecastClient\Shared\Config\ForecastClientQueueConstants;
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

    public function start(): ActivityDtoCollection
    {
        //ToDo: Pass last collected date
        $activityDtoCollection = $this->activityFacade->collect();
        $this->queueClientFacade->sendMessages(
            ForecastClientQueueConstants::QUEUE_NAME,
            $this->createMessageCollectionDto($activityDtoCollection)
        );

        //        $this->storeLastImport(max($this->getActivityDateArray($activityDtoCollection)));

        return $activityDtoCollection;
    }

    //    private function storeLastImport(DateTime $lastImportDateTime)
    //    {
    //        //ToDo: FK Full User
    //        $fcImportState = new FcImportState();
    //        $fcImportState->fk_user_id = 0;
    //        $fcImportState->last_import_timestamp = $lastImportDateTime;
    //        $this->entityManager->persist($fcImportState);
    //        $this->entityManager->flush();
    //    }

    private function createMessageCollectionDto(ActivityDtoCollection $activityDtoCollection): MessageCollectionDto
    {
        $messages = [];
        foreach ($activityDtoCollection as $activityDto) {
            $messages[] =
                new MessageDto(
                    ['created' => $activityDto->created->format('c')] + (array)$activityDto,
                    ForecastClientQueueConstants::QUEUE_NAME,
                    ForecastClientQueueConstants::IMPORT_EVENT
                );
        }

        return new MessageCollectionDto(...$messages);
    }

//    private function getActivityDateArray(ActivityDtoCollection $activityDtoCollection): array
//    {
//        return array_map(
//            static fn(ActivityDto $activityDto) => $activityDto->created,
//            $activityDtoCollection->activityDtos
//        );
//    }
}
