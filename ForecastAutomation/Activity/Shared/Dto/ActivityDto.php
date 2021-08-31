<?php

namespace ForecastAutomation\Activity\Shared\Dto;

use DateTime;
use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class ActivityDto extends AbstractDto
{
    public function __construct(
        public string $link,
        public string $activityId,
        public string $publicId,
        public string $needle,
        public string $description,
        public DateTime $created,
        public DateTime $updated,
        public string $authorName,
        public string $authorEmailAddress,
        public string $authorId,
    ) {
    }
}
