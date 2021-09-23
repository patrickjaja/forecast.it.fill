<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\GitlabClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\GitlabClient\Shared\Dto\GitlabQueryDto;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * @method \ForecastAutomation\GitlabClient\GitlabClientFacade getFacade()
 */
class GitlabActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public const ALLOWED_ACTION_NAMES = ['commented on', 'approved'];
    public const ACTIVITY_SUFFIX = 'Entwicklungsprozess';
    public const ACTIVITY_DURATION = 15;

    public function collect(): PromiseInterface
    {
        $wrapPromise = new Promise(
            function () use (&$wrapPromise) {
                $wrapPromise->resolve(
                    $this->mapEventsToActivity(
                        $this->getFacade()->getEvents(new GitlabQueryDto(date(date('Y-m-d', strtotime('-1 day')))))
                    )
                );
            }
        );
        return $wrapPromise;
    }

    private function mapEventsToActivity(array $events): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($events as $event) {
            if (\in_array($event->action_name, self::ALLOWED_ACTION_NAMES, true)) {
                $duration = self::ACTIVITY_DURATION;

                try {
                    $ticketNr = $this->getNeedle($event->target_title);
                    if (isset($activityDtoArray[$ticketNr])) {
                        $duration = self::ACTIVITY_DURATION + $activityDtoArray[$ticketNr]->duration;
                    }
                    $activityDtoArray[$ticketNr] = new ActivityDto(
                        $ticketNr,
                        sprintf('%s: %s (%s)', self::ACTIVITY_SUFFIX, $event->target_title, $event->action_name),
                        new \DateTime($event->created_at),
                        $duration
                    );
                } catch (\Exception $e) {
                    // needle not found. no activity will be created, its ok.
                }
            }
        }

        return new ActivityDtoCollection(...array_values($activityDtoArray));
    }

    private function getNeedle(string $target_title): string
    {
        $matchPattern = sprintf('(%s-[0-9]{1,})i', $_ENV['GITLAB_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if (0 === $resultMatch || ! isset($match[0])) {
            throw new \Exception('gitlab needle not found for target_title: '.$target_title);
        }

        return strtoupper($match[0]);
    }
}
