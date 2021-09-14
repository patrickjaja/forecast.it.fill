<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomationTests\MattermostClient;

use ForecastAutomation\MattermostClient\Business\MattermostApi;
use ForecastAutomation\MattermostClient\MattermostClientFacade;
use ForecastAutomation\MattermostClient\MattermostClientFactory;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostConfigDto;
use ForecastAutomation\MattermostClient\Shared\Dto\MattermostPostsQueryDto;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\HasMessageChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\IsDirectChannelFilter;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers
 */
final class MattermostClientFacadeTest extends TestCase
{
    public const LAST_POST = '2021-01-02 00:00:00';
    public const CHANNEL_TYPE = 'D';
    public const MSG_COUNT = 1;
    public const CHANNEL_FILTER_LAST_POSTS = '2021-01-01 00:00:00';
    public const POSTS_FILTER_LAST_POSTS = '2021-01-01 00:00:00';

    public function testCanGetChannel(): void
    {
        $channels = $this->createMattermostClientFacade(
            $this->createChannelResponse((int) ((new \DateTime(self::LAST_POST))->format('U')) * 1000)
        )->getChannel(
            [
                new HasMessageChannelFilter(new \DateTime(self::CHANNEL_FILTER_LAST_POSTS)),
                new IsDirectChannelFilter(),
            ]
        );
        static::assertCount(1, $channels);
        static::assertSame(self::MSG_COUNT, $channels[0]->total_msg_count);
        static::assertSame(self::CHANNEL_TYPE, $channels[0]->type);
        static::assertSame((new \DateTime(self::LAST_POST))->format('U') * 1000, $channels[0]->last_post_at);
    }

    public function testCanGetPosts(): void
    {
        $posts = $this->createMattermostClientFacade($this->createPostsResponse())->getPosts(
            new MattermostPostsQueryDto('test-id', new \DateTime(self::POSTS_FILTER_LAST_POSTS))
        );
        static::assertCount(1, $posts);
        static::assertSame('test-id-1234', $posts[0]['post-id']);
    }

    private function createMattermostClientFacade(string $jsonApiResponse): MattermostClientFacade
    {
        $clientMock = $this->getMockBuilder(Client::class)
            ->onlyMethods(['request'])
            ->getMock()
        ;
        $clientMock
            ->method('request')
            ->willReturn(
                new Response(200, ['X-Foo' => 'Bar'], $jsonApiResponse)
            )
        ;

        $mattermostClientFactoryMock = $this->getMockBuilder(MattermostClientFactory::class)
            ->onlyMethods(['createMattermostApi'])
            ->getMock()
        ;

        $mattermostApi = new MattermostApi($clientMock, new MattermostConfigDto('', '', '', ''));
        $mattermostApi::$token = 'test-token';
        $mattermostClientFactoryMock
            ->method('createMattermostApi')
            ->willReturn($mattermostApi)
        ;

        $mattermostClientFacadeMock = $this->getMockBuilder(MattermostClientFacade::class)
            ->onlyMethods(['getFactory'])
            ->getMock()
        ;
        $mattermostClientFacadeMock
            ->method('getFactory')
            ->willReturn($mattermostClientFactoryMock)
        ;

        return $mattermostClientFacadeMock;
    }

    private function createPostsResponse(): string
    {
        return '{"posts":[{"post-id":"test-id-1234","message":"test-msg"}]}';
    }

    private function createChannelResponse(int $lastPostAt): string
    {
        return '[{"id":"test-id-1234","total_msg_count":'.self::MSG_COUNT.',"type":"'.self::CHANNEL_TYPE.'","last_post_at":'.$lastPostAt.'}]';
    }
}
