<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
