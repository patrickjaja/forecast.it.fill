<?php

declare(strict_types = 1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Shared\Plugin;

use DateTime;
use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\MattermostClient\MattermostClientFacade;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

class MattermostActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public const POST_SUFFIX = 'Abstimmung';
    public const ACTIVITY_DURATION = 15;

    public function __construct(
        private array $channelFilterCollection,
        private MattermostClientFacade $mattermostClientFacade,
    ) {
    }

    public function collect(): PromiseInterface
    {
        return $this->mattermostClientFacade
            ->getChannel($this->channelFilterCollection)
            ->then(
                function(array $channels) {
                    $postPromises = [];
                    foreach ($channels as $channel) {
                        $postPromises[] = $this->mattermostClientFacade->getPosts(
                            new MattermostPostsQueryDto($channel->id, DateTime::createFromFormat('Y-m-d H:i','2021-10-11 00:00'))
                        );
                    }

                    $postsCollection = Utils::all($postPromises)->wait();

                    return $this->mapEventsToActivity($this->filterPosts($postsCollection));
                }
            );
    }

    private function filterPosts(array $postsCollection): array
    {
        $filteredPosts = [];
        //ToDo: Add messageAnalyserPlugins with two plugins 1. check for Ticket Needle, 2. follow MR links and check Ticket behind
        foreach ($postsCollection as $postpackCollection) {
            foreach ($postpackCollection as $post) {
                if ($this->hasNeedle($post['message'])) {
                    $filteredPosts[] = $post;
                }
            }
        }

        return $filteredPosts;
    }

    private function mapEventsToActivity(array $filteredPostsCollection): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($filteredPostsCollection as $post) {
            $duration = self::ACTIVITY_DURATION;
            $ticketNr = $this->getNeedle($post['message']);
            if (isset($activityDtoArray[$ticketNr])) {
                $duration = self::ACTIVITY_DURATION + $activityDtoArray[$ticketNr]->duration;
            }
            $activityDtoArray[$ticketNr] = new ActivityDto(
                $ticketNr,
                sprintf('%s: %s', self::POST_SUFFIX, $ticketNr),
                new \DateTime(date('d-m-Y', (int)($post['create_at'] / 1000))),
                $duration
            );
        }

        return new ActivityDtoCollection(...array_values($activityDtoArray));
    }

    private function getNeedle(string $target_title): string
    {
        $matchPattern = sprintf('(%s-[0-9]{1,})i', $_ENV['GITLAB_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if (0 === $resultMatch || !isset($match[0])) {
            throw new \Exception('gitlab needle not found for target_title: ' . $target_title);
        }

        return strtoupper($match[0]);
    }

    private function hasNeedle(string $target_title): bool
    {
        $matchPattern = sprintf('(%s-[0-9]{1,})i', $_ENV['MATTERMOST_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if (0 === $resultMatch || !isset($match[0])) {
            return false;
        }

        return true;
    }
}
