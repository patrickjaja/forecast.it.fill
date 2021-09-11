<?php

namespace ForecastAutomation\MattermostClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class MattermostConfigDto extends AbstractDto
{
    public function __construct(
        public string $host,
        public string $username,
        public string $password,
        public string $teamId,
    ) {
    }
}
