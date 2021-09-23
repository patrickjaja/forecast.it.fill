<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\ChannelFilterInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;

/**
 * @method \ForecastAutomation\MattermostClient\MattermostClientFacade getFacade()
 */
class MattermostActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    public const POST_SUFFIX = 'Abstimmung';
    public const ACTIVITY_DURATION = 15;

    private array $channelFilterCollection;

    public function __construct(ChannelFilterInterface ...$channelFilterCollection)
    {
        $this->channelFilterCollection = $channelFilterCollection;
        parent::__construct();
    }

    public function collect(): PromiseInterface
    {
        return $this->getFacade()
            ->getChannel($this->channelFilterCollection)
            ->then(
                function (array $channels) {
                    $postPromises = [];
                    foreach ($channels as $channel) {
                        $postPromises[] = $this->getFacade()->getPosts(
                            (new MattermostPostsQueryDto($channel->id, new \DateTime(date('Y-m-d'))))
                        );
                    }

                    $postsCollection = Utils::all($postPromises)->wait();

                    return $this->mapEventsToActivity($this->filterPosts($postsCollection));
                }
            )
        ;
    }

    private function filterPosts(array $postsCollection): array
    {
        $filteredPosts = [];

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
                new \DateTime(date('d-m-Y', (int) ($post['create_at'] / 1000))),
                $duration
            );
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

    private function hasNeedle(string $target_title): bool
    {
        $matchPattern = sprintf('(%s-[0-9]{1,})i', $_ENV['MATTERMOST_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if (0 === $resultMatch || ! isset($match[0])) {
            return false;
        }

        return true;
    }
}
