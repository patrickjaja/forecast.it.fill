<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\PeriodicalActivityDataImport\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class PeriodicalActivityConfigDto extends AbstractDto
{
    public function __construct(
        public string $note,
        public int $duration,
        public string $project_id,
        public string $frequency,
    ) {
    }
}
