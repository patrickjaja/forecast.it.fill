<?php

namespace ForecastAutomation\GitlabClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class GitlabQueryDto extends AbstractDto
{
    public function __construct(
        public string $after,
    ) {
    }
}
