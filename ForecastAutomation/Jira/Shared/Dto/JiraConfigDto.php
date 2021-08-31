<?php

namespace ForecastAutomation\Jira\Shared\Dto;

use ForecastAutomation\Kernel\Shared\Dto\AbstractDto;

class JiraConfigDto extends AbstractDto
{
    public function __construct(
        public string $jiraPassword,
        public string $jiraHost,
        public string $jiraUser,
        public string $jiraMaxResults,
        public string $jiraQuery
    ) {
    }
}
