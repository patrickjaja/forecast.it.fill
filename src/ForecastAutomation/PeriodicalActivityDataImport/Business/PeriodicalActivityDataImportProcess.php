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
use ForecastAutomation\ForecastClient\ForecastClientFacade;
use ForecastAutomation\PeriodicalActivityDataImport\Shared\Dto\PeriodicalActivityConfigDto;

class PeriodicalActivityDataImportProcess
{
    public const PERIODICAL_SUFFIX = 'Geplanter Termin';

    public function __construct(
        private PeriodicalActivityConfigReader $periodicalActivityConfigReader,
        private ForecastClientFacade $forecastClientFacade
    ) {
    }

    public function start(string $periodicalDate): int
    {
        return $this->forecastClientFacade->writeActivities(
            $this->generateActivity(
                $this->periodicalActivityConfigReader->readPeriodicalConfig($periodicalDate),
                $periodicalDate
            )
        );
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
