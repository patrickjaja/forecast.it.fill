<?php

namespace ForecastAutomation\Jira\Business;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Jira\Shared\Dto\JiraConfigDto;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueService;

/**
 * @method \ForecastAutomation\Jira\JiraFactory getFactory()
 */
class JiraCollector
{
    public function __construct(private JiraConfigDto $jiraConfigDto, private IssueService $jiraClient)
    {
    }

    public function getJiraActivities(string $startDate): ActivityDtoCollection
    {
        $activities = $this->jiraClient->search(
            sprintf($this->jiraConfigDto->jiraQuery, $startDate),
            0,
            $this->jiraConfigDto->jiraMaxResults
        );
        $ticketList = array_map(
            static function(Issue $issue) {
                return $issue->key;
            },
            $activities->getIssues()
        );

        $jiraActivities = [];
        foreach ($ticketList as $issueKey) {
            $comments = $this->jiraClient->getComments($issueKey);
            foreach ($comments->comments as $comment) {
                if (date('Y-m-d H:i', strtotime($comment->updated)) >= $startDate
                    && (isset($comment->author->emailAddress) && $comment->author->emailAddress === $this->jiraConfigDto->jiraUser)) {
                    $jiraActivities[$issueKey][] = $comment;
                }
            }
        }

        return $this->createActivityDtoCollection($jiraActivities);
    }

    private function createActivityDtoCollection(array $jiraActivities): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($jiraActivities as $jiraTicketNumber => $jiraActivity) {
            $activityDtoArray [] = new ActivityDto(
                $jiraActivity[0]->self,
                $jiraActivity[0]->id,
                $jiraTicketNumber,
                $jiraTicketNumber,
                $jiraActivity[0]->body,
                new \DateTime($jiraActivity[0]->created),
                new \DateTime($jiraActivity[0]->updated),
                $jiraActivity[0]->updateAuthor->displayName,
                $jiraActivity[0]->updateAuthor->emailAddress,
                $jiraActivity[0]->updateAuthor->accountId,
            );
        }

        return new ActivityDtoCollection(...$activityDtoArray);
    }
}
