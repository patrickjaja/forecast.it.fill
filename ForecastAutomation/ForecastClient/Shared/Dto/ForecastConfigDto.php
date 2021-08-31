<?php

namespace ForecastAutomation\ForecastClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class ForecastConfigDto extends AbstractDto
{
    public function __construct(
        public string $forecastHost,
        public string $forecastApiKey,
        public string $forecastProjectId,
        public string $forecastPersonId,
        public string $forecastFallbackTaskId
    ) {
    }
}
