<?php

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
