<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\JiraClient;

use ForecastAutomation\JiraClient\Business\JiraCollector;
use ForecastAutomation\JiraClient\Shared\Dto\JiraConfigDto;
use ForecastAutomation\Kernel\AbstractFactory;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;

class JiraClientFactory extends AbstractFactory
{
    public function createJiraConfigDto(): JiraConfigDto
    {
        return new JiraConfigDto(
            $_ENV['JIRA_HOST'],
            $_ENV['JIRA_USER'],
            true,
            $_ENV['JIRA_TOKEN'],
            (int) $_ENV['JIRA_MAX_RESULTS'],
            $_ENV['JIRA_QUERY'],
        );
    }

    public function createJiraClient(): IssueService
    {
        return new IssueService(new ArrayConfiguration(
            [
                'jiraHost' => $this->createJiraConfigDto()->jiraHost,
                'useTokenBasedAuth' => $this->createJiraConfigDto()->useTokenBasedAuth,
                'personalAccessToken' => $this->createJiraConfigDto()->personalAccessToken,
            ]
        ));
    }

    public function createJiraCollector(): JiraCollector
    {
        return new JiraCollector($this->createJiraConfigDto(), $this->createJiraClient());
    }
}
