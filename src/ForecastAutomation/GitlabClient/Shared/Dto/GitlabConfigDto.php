<?php

namespace ForecastAutomation\GitlabClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class GitlabConfigDto extends AbstractDto
{
    public function __construct(
        public string $gitlabHost,
        public string $gitlabToken,
    ) {
    }
}
