<?php

namespace ForecastAutomation\MattermostClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class MattermostPostsQueryDto extends AbstractDto
{
    public function __construct(
        public string $channelId,
        public \DateTime $since,
    ) {
    }
}
