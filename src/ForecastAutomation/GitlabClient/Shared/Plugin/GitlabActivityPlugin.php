<?php

namespace ForecastAutomation\GitlabClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;

/**
 * @method \ForecastAutomation\GitlabClient\GitlabClientFacade getFacade()
 */
class GitlabActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    private const ALLOWED_ACTION_NAMES = ['commented on', 'approved'];
    private const ACTIVITY_SUFFIX = 'Entwicklungsprozess';
    private const ACTIVITY_DURATION = 15;

    public function collect(): ActivityDtoCollection
    {
        return $this->mapEventsToActivity(
            $this->getFacade()->getEvents(new GitlabQueryDto(date(date('Y-m-d', strtotime('-1 day')))))
        );
    }

    private function mapEventsToActivity(array $events): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($events as $event) {
            if (in_array($event->action_name, self::ALLOWED_ACTION_NAMES, true)) {
                $duration = self::ACTIVITY_DURATION;
                $ticketNr = $this->getNeedle($event->target_title);
                if (isset($activityDtoArray[$ticketNr])) {
                    $duration = self::ACTIVITY_DURATION + $activityDtoArray[$ticketNr]->duration;
                }
                $activityDtoArray [$ticketNr] = new ActivityDto(
                    $ticketNr,
                    sprintf('%s: %s (%s)', self::ACTIVITY_SUFFIX, $event->target_title, $event->action_name),
                    new \DateTime($event->created_at),
                    $duration
                );
            }
        }

        return new ActivityDtoCollection(...array_values($activityDtoArray));
    }

    private function getNeedle(string $target_title): string
    {
        $matchPattern = sprintf('(%s-[0-9]{3,})i', $_ENV['GITLAB_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if ($resultMatch === 0 || !isset($match[0])) {
            throw new \Exception('gitlab needle not found for target_title: ' . $target_title);
        }

        return strtoupper($match[0]);
    }
}
