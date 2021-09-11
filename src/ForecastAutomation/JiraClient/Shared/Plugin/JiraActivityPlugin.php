<?php

namespace ForecastAutomation\JiraClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;

/**
 * @method \ForecastAutomation\JiraClient\JiraFacade getFacade()
 */
class JiraActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    private const ACTIVITY_DURATION = 30;
    private const COMMENT_IDENTIFIER = 'Ticket Bearbeitung';

    public function collect(): ActivityDtoCollection
    {
        return $this->createActivityDtoCollection($this->getFacade()->getComments(date('Y-m-d 00:00')));
    }

    private function createActivityDtoCollection(array $jiraComments): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($jiraComments as $jiraTicketNumber => $jiraComment) {
            $activityDtoArray [] = new ActivityDto(
                $jiraTicketNumber,
                sprintf(
                    '%s: %s - %s',
                    self::COMMENT_IDENTIFIER,
                    $jiraTicketNumber,
                    sprintf('%s...',substr(preg_replace('/\[[^)]+\]/', '', $jiraComment[0]->body), 0, 60))
                ),
                new \DateTime($jiraComment[0]->updated),
                self::ACTIVITY_DURATION * count($jiraComment)
            );
        }

        return new ActivityDtoCollection(...$activityDtoArray);
    }
}
