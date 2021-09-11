<?php

namespace ForecastAutomation\MattermostClient\Shared\Dto;

use DateTime;
use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class MattermostChannelFilterQueryDto extends AbstractDto
{
    public function __construct(
        public DateTime $lastPostAt,
    ) {
    }
}
