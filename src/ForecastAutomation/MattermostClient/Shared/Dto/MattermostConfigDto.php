<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
