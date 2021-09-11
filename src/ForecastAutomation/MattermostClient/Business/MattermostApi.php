<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\MattermostClient\Business;

use ForecastAutomation\MattermostClient\Shared\Dto\MattermostChannelFilterQueryDto;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostConfigDto;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;
use GuzzleHttp\Client;

class MattermostApi
{
    private const AUTH_API = '/api/v4/users/login';
    private const CHANNEL_API = '/api/v4/users/me/teams/%s/channels';
    private const POSTS_API = '/api/v4/channels/%s/posts';

    public static string $token = '';

    public function __construct(private Client $guzzleClient, private MattermostConfigDto $mattermostConfigDto)
    {
    }

    public function getChannel(MattermostChannelFilterQueryDto $channelFilterQueryDto): array
    {
        $this->auth();
        $res = $this->guzzleClient->request(
            'GET',
            sprintf(self::CHANNEL_API, $this->mattermostConfigDto->teamId),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.static::$token,
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        $channelArray = json_decode((string)$res->getBody(), null, 512, JSON_THROW_ON_ERROR);

        return $this->applyChannelFilter($channelArray, $channelFilterQueryDto);
    }

    public function getPosts(MattermostPostsQueryDto $postsQueryDto): array
    {
        $this->auth();
        $res = $this->guzzleClient->request(
            'GET',
            sprintf(self::POSTS_API, $postsQueryDto->channelId),
            [
                'query' => ['since' => (int)$postsQueryDto->since->format('U') * 1000],
                'headers' => [
                    'Authorization' => 'Bearer '.static::$token,
                    'Content-Type' => 'application/json',
                ],
            ],
        );

        return json_decode((string)$res->getBody(), true, 512, JSON_THROW_ON_ERROR)->posts;
    }

    private function auth(): string
    {
        if ('' !== static::$token) {
            return static::$token;
        }
        $res = $this->guzzleClient->request(
            'POST',
            self::AUTH_API,
            [
                'body' => json_encode(
                    [
                        'login_id' => $this->mattermostConfigDto->username,
                        'password' => $this->mattermostConfigDto->password,
                    ],
                    JSON_THROW_ON_ERROR
                ),
            ],
        );
        $token = $res->getHeader('token');
        if (0 === \count($token)) {
            throw new \Exception('could not auth to mattermost');
        }
        static::$token = $token[0];

        return static::$token;
    }

    private function applyChannelFilter(
        array $channelArray,
        MattermostChannelFilterQueryDto $channelFilterQueryDto
    ): array {
        $filteredChannel = [];
        foreach ($channelArray as $channel) {
            if ($channel->total_msg_count > 0
                && $this->isDirectChannel($channel)
                && $channel->last_post_at >= ((int) $channelFilterQueryDto->lastPostAt->format('U') * 1000)) {
                $filteredChannel[] = $channel;
            }
        }

        return $filteredChannel;
    }

    private function isDirectChannel(\stdClass $channel): bool
    {
        return 'D' === $channel->type;
    }
}
