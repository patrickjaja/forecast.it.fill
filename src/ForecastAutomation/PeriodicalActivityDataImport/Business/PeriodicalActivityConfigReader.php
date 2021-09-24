<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport\Business;

use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\PeriodicalActivityDataImport\Shared\Dto\PeriodicalActivityConfigDto;
use JsonSchema\Validator;

class PeriodicalActivityConfigReader
{
    public function __construct(
        private string $periodicalActivityConfig,
        private string $periodicalActivitySchemaPath,
        private Validator $validator,
        private LogFacade $logFacade,
    ) {
    }

    /**
     * @return PeriodicalActivityConfigDto[] array
     */
    public function readPeriodicalConfig(string $periodicalDate): array
    {
        try {
            //ToDo: Move to separate Plugins in Business Layer to reduce class complexity and responsibility
            $periodicalConfigCollection = json_decode(
                $this->periodicalActivityConfig,
                null,
                JSON_PARTIAL_OUTPUT_ON_ERROR,
                JSON_THROW_ON_ERROR
            );

            $this->validator->validate(
                $periodicalConfigCollection,
                (object) ['$ref' => $this->periodicalActivitySchemaPath]
            );

            if ($this->validator->isValid()) {
                $periodicalConfigDtoCollection = $this->filterPeriodicalConfigDto(
                    $this->periodicalConfigDtoMapper($periodicalConfigCollection),
                    $periodicalDate
                );
            } else {
                $this->logFacade->error(
                    \sprintf(
                        'JSON (%s) is not validate. %s',
                        $this->periodicalActivityConfig,
                        json_encode($this->validator->getErrors(), JSON_THROW_ON_ERROR)
                    )
                );
            }
        } catch (\JsonException $exception) {
            $this->logFacade->error('Invalid JSON.', $exception);

            throw $exception;
        }

        return $periodicalConfigDtoCollection;
    }

    /**
     * @return PeriodicalActivityConfigDto[] array
     */
    private function periodicalConfigDtoMapper(array $periodicalConfigCollection): array
    {
        $periodicalConfigDtoCollection = [];
        foreach ($periodicalConfigCollection as $periodicalConfig) {
            $periodicalConfigDtoCollection[] = new PeriodicalActivityConfigDto(...(array) $periodicalConfig);
        }

        return $periodicalConfigDtoCollection;
    }

    /**
     * @return PeriodicalActivityConfigDto[] array
     */
    private function filterPeriodicalConfigDto(array $periodicalConfigDtoCollection, string $periodicalDate): array
    {
        $activityCandidates = [];
        foreach ($periodicalConfigDtoCollection as $periodicalActivityConfigDto) {
            if (str_contains($periodicalActivityConfigDto->frequency, date('N', strtotime($periodicalDate)))) {
                $activityCandidates[] = $periodicalActivityConfigDto;
            }
        }

        return $activityCandidates;
    }
}
