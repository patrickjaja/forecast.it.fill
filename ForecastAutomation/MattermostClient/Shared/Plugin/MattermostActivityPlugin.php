<?php

namespace ForecastAutomation\MattermostClient\Shared\Plugin;

use ForecastAutomation\Activity\Shared\Dto\ActivityDto;
use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginInterface;
use ForecastAutomation\Kernel\Shared\Plugin\AbstractPlugin;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostChannelFilterQueryDto;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;

/**
 * @method \ForecastAutomation\MattermostClient\MattermostClientFacade getFacade()
 */
class MattermostActivityPlugin extends AbstractPlugin implements ActivityPluginInterface
{
    private const POST_SUFFIX = 'Abstimmung';
    private const ACTIVITY_DURATION = 15;

    public function collect(): ActivityDtoCollection
    {
        $channelWithActivity = $this->getFacade()->getChannel(
            new MattermostChannelFilterQueryDto(new \DateTime(date('Y-m-d')))
        );
        $filteredPostsCollection = [];
        foreach ($channelWithActivity as $channel) {
            $postsCollection = $this->getFacade()->getPosts(
                (new MattermostPostsQueryDto($channel->id, new \DateTime(date('Y-m-d'))))
            );

            $filteredPostsCollection = array_merge(
                $filteredPostsCollection,
                $this->filterPosts($postsCollection)
            );
        }

        return $this->mapEventsToActivity($filteredPostsCollection);
    }

    private function filterPosts(\stdClass $postsCollection)
    {
        $filteredPosts = [];
        foreach ($postsCollection as $post) {
            if ($this->hasNeedle($post->message)) {
                $filteredPosts[] = $post;
            }
        }

        return $filteredPosts;
    }

    private function mapEventsToActivity(array $filteredPostsCollection): ActivityDtoCollection
    {
        $activityDtoArray = [];
        foreach ($filteredPostsCollection as $post) {
            $duration = self::ACTIVITY_DURATION;
            $ticketNr = $this->getNeedle($post->message);
            if (isset($activityDtoArray[$ticketNr])) {
                $duration = self::ACTIVITY_DURATION + $activityDtoArray[$ticketNr]->duration;
            }
            $activityDtoArray[$ticketNr] = new ActivityDto(
                $ticketNr,
                sprintf('%s: %s', self::POST_SUFFIX, $ticketNr),
                new \DateTime(date('d-m-Y', ($post->create_at / 1000))),
                $duration
            );
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

    private function hasNeedle(string $target_title): bool
    {
        $matchPattern = sprintf('(%s-[0-9]{3,})i', $_ENV['MATTERMOST_PATTERN']);
        $resultMatch = preg_match($matchPattern, $target_title, $match);
        if ($resultMatch === 0 || !isset($match[0])) {
            return false;
        }

        return true;
    }
}
