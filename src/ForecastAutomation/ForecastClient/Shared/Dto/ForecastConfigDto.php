<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

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
