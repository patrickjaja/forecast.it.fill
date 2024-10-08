<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\JiraClient\Business;

use ForecastAutomation\JiraClient\Shared\Dto\JiraConfigDto;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueService;

/**
 * @method \ForecastAutomation\JiraClient\JiraClientFactory getFactory()
 */
class JiraCollector
{
    public function __construct(private JiraConfigDto $jiraConfigDto, private IssueService $jiraClient)
    {
    }

    public function getComments(string $startDate): array
    {
        $activities = $this->jiraClient->search(
            sprintf($this->jiraConfigDto->jiraQuery, $startDate),
            0,
            $this->jiraConfigDto->jiraMaxResults
        );
        $ticketList = array_map(
            static fn (Issue $issue) => $issue->key,
            $activities->getIssues()
        );

        $jiraActivities = [];
        foreach ($ticketList as $issueKey) {
            $comments = $this->jiraClient->getComments($issueKey);
            foreach ($comments->comments as $comment) {
                $passedDate = \DateTime::createFromFormat('Y-m-d H:i', $startDate);
                if (($comment->updated >= $passedDate)
                    && (isset($comment->author->emailAddress) && $comment->author->emailAddress === $this->jiraConfigDto->jiraUser)) {
                    $jiraActivities[$issueKey][] = $comment;
                }
            }
        }

        return $jiraActivities;
    }
}
