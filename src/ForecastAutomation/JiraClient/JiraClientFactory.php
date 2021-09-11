<?php

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
            $_ENV['JIRA_TOKEN'],
            $_ENV['JIRA_HOST'],
            $_ENV['JIRA_USER'],
            $_ENV['JIRA_MAX_RESULTS'],
            $_ENV['JIRA_QUERY'],
        );
    }

    public function createJiraClient(): IssueService
    {
        return new IssueService(new ArrayConfiguration((array)$this->createJiraConfigDto()));
    }

    public function createJiraCollector(): JiraCollector
    {
        return new JiraCollector($this->createJiraConfigDto(), $this->createJiraClient());
    }
}
