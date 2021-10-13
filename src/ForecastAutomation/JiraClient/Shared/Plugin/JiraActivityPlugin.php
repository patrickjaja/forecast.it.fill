<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\JiraClient\Shared\Plugin;

use DateTime;
use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\JiraClient\JiraClientFacade;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use JiraRestApi\JiraClient;

class JiraActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public const ACTIVITY_DURATION = 30;
    public const COMMENT_IDENTIFIER = 'Ticket Bearbeitung';

    public function __construct(private JiraClientFacade $jiraClientFacade)
    {

    }

    public function collect(): PromiseInterface
    {
        $wrapPromise = new Promise(
            function () use (&$wrapPromise) {
                $comments = $this->jiraClientFacade->getComments(DateTime::createFromFormat('Y-m-d H:i','2021-10-11 00:00')->format('Y-m-d H:i')); // date('Y-m-d 00:00')
                $wrapPromise->resolve($this->createActivityDtoCollection($comments));
            }
        );

        return $wrapPromise;
    }

    private function createActivityDtoCollection(array $jiraComments): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($jiraComments as $jiraTicketNumber => $jiraComment) {
            $activityDtoArray[] = new ActivityDto(
                $jiraTicketNumber,
                sprintf(
                    '%s: %s - %s',
                    self::COMMENT_IDENTIFIER,
                    $jiraTicketNumber,
                    sprintf('%s...', substr(preg_replace('/\[[^)]+\]/', '', $jiraComment[0]->body), 0, 60))
                ),
                new \DateTime($jiraComment[0]->updated),
                self::ACTIVITY_DURATION * \count($jiraComment)
            );
        }

        return new ActivityDtoCollection(...$activityDtoArray);
    }
}
