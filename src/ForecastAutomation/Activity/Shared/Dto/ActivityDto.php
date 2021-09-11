<?php

declare(strict_types=1);

// This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.

namespace ForecastAutomation\Activity\Shared\Dto;

use DateTime;
use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class ActivityDto extends AbstractDto
{
    public function __construct(
        public string $needle,
        public string $description,
        public DateTime $created,
        public int $duration,
    ) {
    }
}
