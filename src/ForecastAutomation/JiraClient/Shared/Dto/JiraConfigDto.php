<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\JiraClient\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class JiraConfigDto extends AbstractDto
{
    public function __construct(
        public string $jiraHost,
        public string $jiraUser,
        public bool $useTokenBasedAuth,
        public string $personalAccessToken,
        public int $jiraMaxResults,
        public string $jiraQuery
    ) {
    }
}
